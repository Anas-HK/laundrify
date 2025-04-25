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
    $request->validate([
        'otp' => 'required|numeric',
    ]);

    $email = session('email');

    if (!$email) {
        return redirect()->route('register')->withErrors(['otp' => 'Session expired. Please register again.']);
    }

    //here we are retriving all the user by email
    $user = User::where('email', $email)->first();

    if (!$user) {
        return back()->withErrors(['otp' => 'User not found. Please try registering again.']);
    }

    // Log the entered OTP and database OTP for debugging
    logger('Entered OTP: ' . $request->otp);
    logger('Database OTP: ' . $user->otp);

    if ($user->otp == $request->otp) {
        $user->is_verified = true;
        $user->otp = null;
        $user->save();

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
        Log::info('Registration attempt:', $request->all());

        $validated = $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Z ]{3,20}$/',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+\-!#$&\'*\/=?^`{|}~]{1,64}@[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => 'required|string|min:8|confirmed',
            'mobile' => 'required|string|regex:/^[0-9]{11}$/',
            'address' => [
                'required',
                'string',
                'min:10',
                'max:50',
                'regex:/^(?=.*[a-zA-Z])(?=.*[0-9]).+$/'
            ],
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|regex:/^[a-zA-Z ]+$/',
            'state' => 'required|string|regex:/^[a-zA-Z ]+$/',
            'zip' => 'required|string|regex:/^[0-9]{6}$/',
            'pickup_time' => 'required|in:morning,afternoon,evening',
            'terms' => 'accepted',
        ], [
            'name.regex' => 'Only English letters allowed (3-20 characters)',
            'email.regex' => 'Please enter a valid email address',
            'mobile.regex' => 'Please enter a valid 11-digit mobile number',
            'address.regex' => 'Address must contain both letters and numbers',
            'city.regex' => 'Only English letters allowed',
            'state.regex' => 'Only English letters allowed',
            'zip.regex' => 'Please enter a valid 6-digit postal code',
        ]);

        Log::info('Validation passed');

        // Rest of your registration logic...
        $otp = rand(100000, 999999);
        Log::info('Generated OTP: ' . $otp);

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
        
        // Test Case 4: Check for empty fields
        if (empty($credentials['email']) || empty($credentials['password'])) {
            return back()->withErrors(['login' => 'Please enter email and password.'])->withInput();
        }
    
        // Attempt to authenticate the user with provided credentials
        if (Auth::attempt($credentials)) {
            // Regenerate session to prevent session fixation attacks
            $request->session()->regenerate();
    
            $user = Auth::user();
    
            // Test Case 3: If user credentials are valid, check for admin
            if ($user->id == 1 || $user->sellerType == 1) {
                return redirect()->route('admin.dashboard')->with('success', 'You are logged in as admin.');
            }
    
            // Redirect to the intended page or home
            return redirect()->intended('/')->with('success', 'You are logged in.');
        }
    
        // Test Case 1: Invalid email or Test Case 2: Wrong password
        if (!User::where('email', $credentials['email'])->exists()) {
            // No such ID exists
            return back()->withErrors(['login' => 'No such ID exists.'])->withInput();
        }
    
        // If the email exists but the password is incorrect
        return back()->withErrors(['login' => 'Wrong password.'])->withInput();
    }
    
    
                    
    public function home()
    {
        return view('home');
    }
}