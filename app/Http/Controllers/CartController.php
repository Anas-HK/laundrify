<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    

    public function add(Request $request)
{
    // Validate service ID
    $request->validate([
        'service_id' => 'required|exists:services,id',
    ]);

    // Fetch the service
    $service = Service::findOrFail($request->service_id);

    $cart = Session::get('cart', []);

    // Add the service to the cart (or update quantity if already exists)
    if (isset($cart[$service->id])) {
        $cart[$service->id]['quantity'] += 1;
    } else {
        // Ensure seller_id is available when adding to cart
        $cart[$service->id] = [
            'id' => $service->id,
            'name' => $service->service_name,
            'price' => $service->service_price,
            'quantity' => 1,
            'seller_id' => $service->seller_id,
        ];
    }

    Session::put('cart', $cart);

    return redirect()->back()->with('success', 'Service added to cart successfully!');
}

    
    
    public function viewCart()
    {
        $cart = Session::get('cart', []);
        return view('cart.view', compact('cart'));
    }

    public function remove(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $cart = Session::get('cart', []);

        // Remove the service from the cart
        unset($cart[$request->service_id]);

        // Update the session
        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Service removed from cart!');
    }
}
