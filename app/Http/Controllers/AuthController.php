<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OtpMail;
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

    
public function showOtpForm()
{
    return view('auth.verify-otp');
}


public function verifyOtp(Request $request)
{
    // Validate the OTP input
    $request->validate([
        'otp' => 'required|numeric',
    ]);

    // Retrieve the email from the session
    $email = session('email');

    if (!$email) {
        // Handle expired or missing session
        return redirect()->route('register')->withErrors(['otp' => 'Session expired. Please register again.']);
    }

    // Retrieve the user by email
    $user = User::where('email', $email)->first();

    if (!$user) {
        return back()->withErrors(['otp' => 'User not found. Please try registering again.']);
    }

    // Log the entered OTP and database OTP for debugging
    logger('Entered OTP: ' . $request->otp);
    logger('Database OTP: ' . $user->otp);

    // Check if the OTP matches
    if ($user->otp == $request->otp) {
        // Mark the user as verified
        $user->is_verified = true;
        $user->otp = null; // Clear the OTP after verification
        $user->save();

        // Clear the email from the session
        session()->forget('email');

        // Redirect to the login page with a success message
        return redirect()->route('login')->with('success', 'Your account has been verified. Please log in.');
    } else {
        // Return error for invalid OTP
        return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }
}

public function register(Request $request) 
{
    try {
        // Add debugging
        Log::info('Registration attempt:', $request->all());

        // Validate with error handling
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'mobile' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'pickup_time' => 'required|in:morning,afternoon,evening',
            'terms' => 'accepted',
        ]);

        Log::info('Validation passed');

        // Generate OTP
        $otp = rand(100000, 999999);
        Log::info('Generated OTP: ' . $otp);

        // Create user first
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'sellerType' => 2,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'pickup_time' => $request->pickup_time,
            'is_verified' => false,
            'otp' => $otp,
        ]);

        Log::info('User created:', ['user_id' => $user->id]);

        // Then try to send email
        Mail::to($request->email)->send(new OtpMail($otp));
        Log::info('OTP email sent');

        session(['email' => $request->email]);
        
        return redirect()->route('verify.otp')->with('success', 'Please check your email for OTP');
        
    } catch (\Exception $e) {
        Log::error('Registration error: ' . $e->getMessage());
        return back()
            ->withInput()
            ->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
    }
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
