<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSellerAccountSuspension
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only check for authenticated sellers
        if (Auth::guard('seller')->check()) {
            $seller = Auth::guard('seller')->user();
            
            if ($seller->is_suspended) {
                // For AJAX requests, return a JSON response
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'error' => 'Your seller account has been suspended. Reason: ' . $seller->suspension_reason,
                    ], 403);
                }
                
                // For normal requests, logout and redirect with message
                Auth::guard('seller')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login.seller')
                    ->withErrors(['login' => 'Your seller account has been suspended. Reason: ' . $seller->suspension_reason]);
            }
        }
        
        return $next($request);
    }
}
