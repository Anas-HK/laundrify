<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
    
        // Invalidate the session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the home page after logout
        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
    


    public function register(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'mobile' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'pickup_time' => 'required|in:morning,afternoon,evening',
            'terms' => 'accepted',
        ]);
    
        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'sellerType' => 2, // Buyer
            'mobile' => $request->mobile,
            'address' => $request->address,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'pickup_time' => $request->pickup_time,
        ]);
    
        // Log the user in
        Auth::login($user);
    
        // Redirect with a success message
        return redirect()->route('home')->with('success', 'Registration successful!');
    }
    

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('login');
    }
    
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('register');
    }
    

    public function login(Request $request)
    {
        
        // Validate input data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            // Regenerate session to prevent session fixation attacks
            $request->session()->regenerate();
    
            $user = Auth::user();
    
            // Check if the user is admin
            if ($user->id == 1 || $user->sellerType == 1) {
                return redirect()->route('admin.dashboard')->with('success', 'You are logged in as admin.');
            }
    
            // Redirect to the intended page or home
            return redirect()->intended('/')->with('success', 'You are logged in.');
        }
        
        // Redirect back with error if login fails
        return back()->withErrors(['login' => 'Invalid email or password.'])->withInput();
    }
    
                    
    public function home()
    {
        return view('home');
    }
}
