<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $roles)
    {
        // Convert roles string to an array
        $rolesArray = explode(',', $roles);

        // Check if the user is logged in
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user has one of the roles
        if (!in_array($user->role, $rolesArray)) {
            return redirect()->route('forbidden'); // Redirect to 403 Forbidden page
        }

        return $next($request);
    }
}
