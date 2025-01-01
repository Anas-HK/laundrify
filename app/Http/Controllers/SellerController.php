<?php

/// SellerController.php

namespace App\Http\Controllers;

use App\Models\Seller;
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:sellers', // unique in sellers table
            'password' => 'required|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'city' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
        ]);
    
        // Handle the uploaded profile image
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        } else {
            $imagePath = null;
        }
    
        // Create a new seller
        $seller = Seller::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'profile_image' => $imagePath,
            'city' => $request->city,
            'area' => $request->area,
            'accountIsApproved' => 0,
        ]);
    
        // Log the seller in and redirect to the seller panel
        Auth::guard('seller')->login($seller);
        return redirect()->route('home');
    }
    
    public function showLoginForm()
    {
        return view('auth.login-seller');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $seller = Seller::where('email', $request->email)->first();

        if (!$seller) {
            return back()->withErrors(['email' => 'Kindly register your account.']);
        }


        if ($seller->accountIsApproved==0) {
            return back()->withErrors(['email' => 'Kindly await account confirmation.']);
        }
        $credentials = $request->only('email', 'password');

        if (Auth::guard('seller')->attempt($credentials)) {
            return redirect()->route('seller.panel');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

// In SellerController.php

// public function sellerPanel()
// {
//     // Get the logged-in seller and their services
//     $seller = auth()->guard('seller')->user();
//     $services = $seller->services; // Only fetch services associated with the logged-in seller
//     return view('seller.panel', compact('services'));
// }

// public function sellerPanel()
// {
//     // Get the logged-in seller and their services
//     $seller = auth()->guard('seller')->user();
//     $services = $seller->services; // Only fetch services associated with the logged-in seller

//     // Get the logged-in seller's orders
//     $orders = Auth::guard('seller')->user()->orders; // Assuming a relationship with orders

//     return view('seller.panel', compact('services', 'orders'));
// }

public function sellerPanel()
{
    // Get the logged-in seller
    $seller = auth()->guard('seller')->user();

    // Get the seller's services
    $services = $seller->services; // Fetch services associated with the logged-in seller

    // Get the seller's orders with necessary relationships
    $orders = $seller->orders()->with(['user', 'items.service'])->get();

    return view('seller.panel', compact('services', 'orders'));
}



    public function logout(Request $request)
{
    Auth::guard('seller')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Redirect to the seller login page
    return redirect()->route('login.seller');
}
}