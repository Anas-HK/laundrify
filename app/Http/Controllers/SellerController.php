<?php
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
    
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        } else {
            $imagePath = null;
        }
    
        $seller = Seller::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'profile_image' => $imagePath,
            'city' => $request->city,
            'area' => $request->area,
            'accountIsApproved' => 0,
        ]);
    
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
            return back()->withErrors(['email' => 'Your account is pending approval.Please wait for admin approval.']);
        }
        $credentials = $request->only('email', 'password');

        if (Auth::guard('seller')->attempt($credentials)) {
            return redirect()->route('seller.panel');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }
 
    
    public function showServices($seller_id)
    {
        $seller = User::findOrFail($seller_id); 
        $services = Service::where('seller_id', $seller_id)->get();
    
        return view('seller-service', compact('seller', 'services')); 
    }
    
public function sellerPanel()
{
    $seller = auth()->guard('seller')->user();

    $services = $seller->services; 
    $orders = $seller->orders()->with(['user', 'items.service'])->get();
    $notifications = $seller->notifications;

    return view('seller.panel', compact('services', 'orders', 'notifications'));
}



    public function logout(Request $request)
{
    Auth::guard('seller')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login.seller');
}
}