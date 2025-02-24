<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // Check if the user is authenticated and has the 'admin' role                              
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // If the user is not an admin, redirect them to the home page or any other page
        return redirect()->route('/')->with('error', 'You do not have admin access.');
    }
}

