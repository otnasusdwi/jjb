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
    // public function handle(Request $request, Closure $next, ...$roles): Response
    // {
    //     if (!auth()->check()) {
    //         return redirect()->route('login');
    //     }

    //     $user = auth()->user();

    //     // Check if user status is active
    //     if ($user->status !== 'active') {
    //         auth()->logout();
    //         return redirect()->route('login')->with('error', 'Your account is not active. Please contact administrator.');
    //     }

    //     // Check if user has required role
    //     if (!empty($roles) && !in_array($user->role, $roles)) {
    //         abort(403, 'Unauthorized access.');
    //     }

    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Safe check status
        if (property_exists($user, 'status') && $user->status !== 'active') {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Your account is not active. Please contact administrator.');
        }

        // Safe check role
        if (!empty($roles)) {
            if (!property_exists($user, 'role') || !in_array($user->role, $roles)) {
                abort(403, 'Unauthorized access.');
            }
        }

        return $next($request);
    }

}
