<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountSuspension
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (Auth::check() && Auth::user()->isSuspended()) {
            // If this is an AJAX request, return a JSON response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Your account has been suspended.',
                    'suspension_reason' => Auth::user()->suspension_reason
                ], 403);
            }
            
            // Log the user out
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Redirect to login with error message
            return redirect()->route('login')->with('error', 
                'Your account has been suspended. Reason: ' . Auth::user()->suspension_reason);
        }
        
        return $next($request);
    }
}
