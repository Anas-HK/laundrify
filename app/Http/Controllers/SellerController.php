<?php
namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\User;
use App\Models\Service;
use App\Models\Order;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SellerController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register-seller');
    }
    public function register(Request $request)
    {
        // Custom validation messages
        $customMessages = [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered. Please use a different email.',
            'email.max' => 'Email cannot exceed 255 characters.',
        ];
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:sellers',
            'password' => 'required|string|min:8|confirmed',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'city' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'terms' => 'required',
        ], $customMessages);
    
        try {
            // Additional custom email validation
            $email = $request->email;
            $errors = [];
            
            // Check for suspicious domains
            $suspiciousDomains = ['example.com', 'test.com', 'sample.com', 'temp-mail.org', 'fakeemail.com'];
            foreach ($suspiciousDomains as $domain) {
                if (strpos($email, $domain) !== false) {
                    $errors['email'] = 'Please use a real email address, not a temporary or test email.';
                    break;
                }
            }
            
            // Check for valid email format beyond Laravel's validation
            $parts = explode('@', $email);
            if (count($parts) == 2) {
                $domain = $parts[1];
                // Check domain has at least one dot
                if (!str_contains($domain, '.') || substr_count($domain, '.') > 3) {
                    $errors['email'] = 'Please provide an email with a valid domain format.';
                }
            }
            
            // Return with errors if any additional validations fail
            if (!empty($errors)) {
                return back()->withInput()->withErrors($errors);
            }
            
            if ($request->hasFile('profile_image')) {
                $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            } else {
                $imagePath = null;
            }
        
            $seller = Seller::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password, // Don't use bcrypt here - the model's mutator will handle it
                'profile_image' => $imagePath,
                'city' => $request->city,
                'area' => $request->area,
                'accountIsApproved' => 0,
            ]);
        
            // Return to registration page with success parameter
            return redirect()->route('register.seller', ['registration' => 'success']);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }
    
    public function showLoginForm()
    {
        return view('auth.login-seller');
    }

    public function login(Request $request)
    {
        // Custom validation messages for login
        $customMessages = [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
        ];

        $request->validate([
            'email' => 'required|string|email:rfc',
            'password' => 'required|string',
        ], $customMessages);

        // Additional email validation for common mistakes
        $email = $request->email;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->withInput()->withErrors(['email' => 'The email format is invalid. Please check for typos.']);
        }

        $seller = Seller::where('email', $request->email)->first();

        if (!$seller) {
            return back()->withErrors(['email' => 'No account found with this email. Please register first.']);
        }

        if ($seller->accountIsApproved==0) {
            return back()->withErrors(['email' => 'Your account is pending approval. Please wait for admin approval.']);
        }
        
        // Check if the seller account is suspended
        if ($seller->is_suspended) {
            return back()->withErrors(['email' => 'Your seller account has been suspended. Reason: ' . $seller->suspension_reason]);
        }
        
        // First, try normal authentication
        $credentials = $request->only('email', 'password');
        if (Auth::guard('seller')->attempt($credentials, $request->filled('remember'))) {
            return redirect()->intended(route('seller.panel'));
        }
        
        // If regular auth fails, try manually checking for double-hashed legacy passwords
        $plainPassword = $request->password;
        $hashedOnce = bcrypt($plainPassword);
        
        // Check if the stored password might be a legacy double-hashed password
        if (password_verify($hashedOnce, $seller->password)) {
            // If legacy password matches, log the user in manually
            Auth::guard('seller')->login($seller, $request->filled('remember'));
            
            // Update the password to the new hashing method
            $seller->password = $plainPassword; // This will use the model's mutator
            $seller->save();
            
            return redirect()->intended(route('seller.panel'));
        }
        
        // If both auth methods fail, return an error
        return back()->withInput()->withErrors(['email' => 'The password you entered is incorrect. Please try again.']);
    }
 
    
    public function showServices($seller_id)
    {
        $seller = Seller::findOrFail($seller_id);
        $services = Service::where('seller_id', $seller_id)->get();
        
        // The feedback table uses seller_id but references the users table
        // We need to check if there's a corresponding user with the same ID
        $feedbacks = Feedback::where('seller_id', $seller_id)
                    ->with('user')
                    ->get();
    
        return view('seller-services', compact('seller', 'services', 'feedbacks'));
    }
    
    
    
    
    
    
    
public function sellerPanel()
{
    $seller = auth()->guard('seller')->user();

    $services = $seller->services; 
    $orders = Order::where('seller_id', $seller->id)
                  ->with(['user', 'items.service'])
                  ->orderBy('created_at', 'desc')
                  ->get();
    
    // Count completed and delivered orders for the dashboard
    $completedOrdersCount = Order::where('seller_id', $seller->id)
                                ->where(function($query) {
                                    $query->where('status', 'completed')
                                          ->orWhere('status', 'delivered');
                                })
                                ->count();
    
    // Get all notifications sorted from latest to oldest
    $notifications = $seller->notifications()->orderBy('created_at', 'desc')->get();
    
    // Get unread notifications count
    $unreadNotificationsCount = $seller->unreadNotifications->count();
    
    // Get customer feedback for this seller
    $feedbacks = Feedback::where('seller_id', $seller->id)
                    ->with(['user', 'order'])
                    ->orderBy('created_at', 'desc')
                    ->get();

    return view('seller.panel', compact('services', 'orders', 'notifications', 'completedOrdersCount', 'feedbacks', 'unreadNotificationsCount'));
}



    public function logout(Request $request)
{
    Auth::guard('seller')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login.seller');
}

/**
 * Show the seller's earnings dashboard
 * 
 * @param Request $request
 * @return \Illuminate\View\View
 */
public function earnings(Request $request)
{
    $seller = auth()->guard('seller')->user();
    if (!$seller) {
        return redirect()->route('login.seller');
    }
    
    $period = $request->get('period', 'all');
    
    // Get earnings for different time periods
    $allTimeEarnings = Order::getSellerEarnings($seller->id);
    $currentPeriodEarnings = Order::getSellerEarnings($seller->id, $period);
    
    // Get detailed data for completed orders
    $completedOrders = Order::where('seller_id', $seller->id)
                      ->where(function($query) {
                          $query->where('status', 'completed')
                                ->orWhere('status', 'delivered');
                      })
                      ->with(['user', 'items.service'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);
    
    // Get monthly earnings data for the chart
    $monthlyData = [];
    for ($i = 0; $i < 6; $i++) {
        $month = now()->subMonths($i);
        $earnings = Order::where('seller_id', $seller->id)
                  ->where(function($query) {
                      $query->where('status', 'completed')
                            ->orWhere('status', 'delivered');
                  })
                  ->whereYear('created_at', $month->year)
                  ->whereMonth('created_at', $month->month)
                  ->sum('total_amount');
        
        $monthlyData[$month->format('M Y')] = $earnings;
    }
    // Reverse to show oldest to newest
    $monthlyData = array_reverse($monthlyData, true);
    
    return view('seller.earnings', [
        'seller' => $seller,
        'period' => $period,
        'allTimeEarnings' => $allTimeEarnings,
        'currentPeriodEarnings' => $currentPeriodEarnings,
        'completedOrders' => $completedOrders,
        'monthlyData' => $monthlyData
    ]);
}

/**
 * Mark all notifications as read
 *
 * @return \Illuminate\Http\Response
 */
public function markNotificationsAsRead()
{
    $seller = auth()->guard('seller')->user();
    $seller->unreadNotifications->markAsRead();
    
    return response()->json(['success' => true]);
}
}