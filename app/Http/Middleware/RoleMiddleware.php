<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get the current user
        $user = Auth::user();
        // print_r($user);
        // die;
        // Check if the user role matches any of the required roles
        if (in_array($user->role, $roles)) {
            return $next($request); // User is allowed to proceed
        }

        // If the user does not have permission, redirect or return a 403
        return response()->view('errors.403', [], 403); // You can create a custom 403 error page
    }
}
