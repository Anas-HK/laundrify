<?php

namespace App\Http\Controllers;
use App\Models\Service;
use App\Models\Seller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Notifications\NewOrderNotification;
use App\Models\Feedback;

use App\Models\User;



class OrderController extends Controller
{

    public function feedback($id) {
        $order = Order::findOrFail($id);
        return view('order.feedbacks', compact('order'));
    }
    
    public function submitFeedback(Request $request, $orderId)
    {
        $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);
    
        $order = Order::findOrFail($orderId);
    
        Feedback::create([
            'order_id' => $orderId,
            'user_id' => auth()->id(), // Get the logged-in user
            'seller_id' => $order->seller_id, // This should be the seller ID from the order
            'feedback' => $request->feedback,
        ]);
    
        return redirect()->route('orders.history')->with('success', 'Feedback submitted successfully!');
    }
    
    
    
    
    
    
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        $order->load(['seller', 'items.service']);
        
        // Ensure the cancelled_at date is properly cast for cancelled orders
        if ($order->status === 'cancelled' && $order->cancelled_at && is_string($order->cancelled_at)) {
            $order->cancelled_at = \Carbon\Carbon::parse($order->cancelled_at);
        }
        
        return view('orders.show', compact('order'));
    }
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
                        ->where(function($query) {
                            $query->where('status', 'completed')
                                  ->orWhere('status', 'delivered')
                                  ->orWhere('status', 'cancelled');
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        // Ensure the cancelled_at date is properly cast for cancelled orders
        $orders->each(function($order) {
            if ($order->status === 'cancelled' && $order->cancelled_at && is_string($order->cancelled_at)) {
                $order->cancelled_at = \Carbon\Carbon::parse($order->cancelled_at);
            }
        });
        
        return view('order.history', compact('orders'));
    }

    public function allOrders()
    {
        $user = auth()->user();

        // Fetch all orders except those with status 'completed' for the authenticated user
        $orders = $user->orders->where('status', '!=', 'completed') ?? collect();

        return view('order.all-orders', compact('orders'));
    }


    public function showCheckout()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        return view('checkout.show', compact('cart'));


    }
    public function placeOrder(Request $request)
    {
        $service = $this->getService($request->service_id); 
    
        if (!$service) {
            Log::error('Invalid service_id for order placement', ['service_id' => $request->service_id]);
            return redirect()->route('home')->with('error', 'Invalid service.');
        }
    
        // Check if seller exists
        $cart = session('cart');
        if (!$cart || !isset($cart[$service->id])) {
            Log::error('Cart data is invalid or empty for order placement');
            return redirect()->route('home')->with('error', 'Invalid cart data.');
        }
    
        $totalAmount = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        $seller = Seller::find($cart[$service->id]['seller_id']);
        if (!$seller) {
            Log::error('Invalid seller_id for order placement', ['seller_id' => $cart[$service->id]['seller_id']]);
            return redirect()->route('home')->with('error', 'Invalid seller.');
        }
    
        try {
            Log::info('Attempting to place an order', [
                'user' => auth()->user(),
                'cart' => $cart,
            ]);
    
            // Validate inputs
            $request->validate([
                'service_id' => 'required|exists:services,id',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'payment_method' => 'required|in:cod,online',
            'transaction_id' => 'required_if:payment_method,online|nullable|string|max:255',
            ]);
            
    
            // This will create the order with seller_id
            $order = Order::create([
                'user_id' => Auth::id(),
                'seller_id' => $cart[$service->id]['seller_id'],
                'address' => $request->address,
                'phone' => $request->phone,
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'transaction_id' => $request->payment_method === 'online' ? $request->transaction_id : null,
                'updated_at' => now(),
                'created_at' => now(),
            ]);
    
            if (!$order) {
                Log::error('Failed to create order', ['data' => $request->all()]);
                throw new \Exception('Order creation failed.');
            }
    
            // Add order items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'service_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
    
            // Clear the cart
            session()->forget('cart');
            Log::info('Order Details:', ['details' => json_encode($order->details)]);
            Log::info('Order Items:', ['items' => $order->items]);
            $seller->notify(new \App\Notifications\NewOrderNotification($seller->name, $order->id, json_encode($order->items)));
            
            return redirect()->route('home')->with('success', 'Order placed successfully.');
    
        } catch (\Exception $e) {
            Log::error('Error occurred during order placement', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('home')->with('error', 'Order placement failed.');
        }
    }
    
    
    private function getService($service_id)
    {
        return Service::find($service_id);
    }

    public function trackOrder(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('order.track', compact('order'));
    }

    public function track(Order $order)
    {
        $user = auth()->user();

        if ($order->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $order->load(['user', 'seller', 'items.service']);

        return view('order.track', compact('order'));
    }


    public function acceptRejectOrder(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:accepted,rejected',
        ]);

        $order->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->route('seller.panel')->with('success', 'Order status updated successfully.');
    }

    public function handleOrder(Order $order)
    {
        $sellerId = auth()->guard('seller')->id();
        if ($order->seller_id !== $sellerId) {
            return redirect()->route('seller.panel')->with('error', 'You do not have permission to manage this order.');
        }

        return view('seller.order-handle', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:accepted,pickup_departed,picked_up,started_washing,ironing,ready_for_delivery,delivered,completed',
        ]);

        $sellerId = auth()->guard('seller')->id();
        if ($order->seller_id !== $sellerId) {
            return redirect()->route('seller.panel')->with('error', 'You do not have permission to update this order.');
        }

        $order->update(['status' => $request->status]);

        // If the order is marked as completed, update the seller's earnings
        if ($request->status === 'completed') {
            // You could add any additional logic here if needed
            // For example, sending a notification to the customer
        }

        return redirect()->route('seller.order.handle', $order)->with('success', 'Order status updated successfully!');
    }

    public function showOrderHandling(Order $order)
    {
        return view('seller.order-handle', compact('order'));
    }

    /**
     * Show the form for cancelling an order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function showCancelForm(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the order can be cancelled
        if (!$order->canBeCancelled()) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'This order cannot be cancelled at its current status.');
        }

        return view('order.cancel', compact('order'));
    }

    /**
     * Process the order cancellation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function cancelOrder(Request $request, Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the order can be cancelled
        if (!$order->canBeCancelled()) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'This order cannot be cancelled at its current status.');
        }

        // Validate the request
        $request->validate([
            'cancellation_reason' => 'required|string|min:5|max:500',
        ]);

        // Update the order
        $order->status = 'cancelled';
        $order->cancellation_reason = $request->cancellation_reason;
        $order->cancelled_at = now();
        $order->save();

        // Notify the seller about the cancellation
        $order->seller->notify(new \App\Notifications\OrderCancelledNotification($order));

        return redirect()->route('orders.all')
            ->with('success', 'Order #' . $order->id . ' has been cancelled successfully. The seller has been notified.');
    }
}
