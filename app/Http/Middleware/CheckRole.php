<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('auth-login-basic')->with('error', 'Please log in to continue.');
        }

        $user = Auth::user();

        if ($user->is_suspended) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('auth-login-basic')->with('error', 'Your account has been suspended: ' . ($user->suspension_reason ?? 'Please contact administrator.'));
        }

        // If no roles specified or user has one of the allowed roles
        if (empty($roles) || in_array($user->role, $roles)) {
            return $next($request);
        }

        // Handle redirection or abort if role unauthorized
        if ($user->role === 'vendor') {
            return redirect()->route('vendor.tools.index')->with('error', 'Access denied. You do not have permission to access the admin portal.');
        }

        if ($user->role === 'admin' || $user->role === 'editor') {
            return redirect()->route('dashboard.analytics')->with('error', 'Access denied.');
        }

        abort(403, 'Unauthorized action.');
    }
}
