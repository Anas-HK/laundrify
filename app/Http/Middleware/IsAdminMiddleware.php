<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Dump and die to see what's happening
        // dd(Auth::check(), Auth::user()->sellerType);
        
        if (Auth::check() && Auth::user()->sellerType == 1) {
            return $next($request);
        }

        return redirect('/')->with('error', 'You do not have admin access.');
    }
} 