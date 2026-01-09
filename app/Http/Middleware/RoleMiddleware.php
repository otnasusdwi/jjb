<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user status is active
        if ($user->status !== 'active') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account is not active. Please contact administrator.');
        }

        // Check if user has required role
        if (!empty($roles)) {
            $hasRole = false;
            foreach ($roles as $role) {
                if ($role === 'admin') {
                    // For admin role, check if user is either admin or super_admin
                    $hasRole = in_array($user->role, ['admin', 'super_admin']);
                } else {
                    // For other roles, check exact match
                    $hasRole = $user->role === $role;
                }
                if ($hasRole) break;
            }
            
            if (!$hasRole) {
                abort(403, 'Unauthorized access.');
            }
        }

        return $next($request);
    }
}
