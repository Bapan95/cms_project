<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Check if the user has the required role
        $user = Auth::user();
        if ($user->role !== $role) {
            return redirect('/403'); // Redirect to 403 page or any other logic you prefer
        }

        return $next($request);
    }
}
