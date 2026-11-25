<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveRoleSelected
{
    /**
     * Admins keep a separate admin workspace; all non-admin accounts share the member workspace.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if ($request->routeIs('logout', 'role.switch')) {
            return $next($request);
        }

        if (! $user->hasVerifiedEmail()) {
            if ($request->routeIs('verification.notice', 'verification.send')) {
                return $next($request);
            }

            return redirect()->route('verification.notice');
        }

        if ($user->is_admin) {
            return $this->handleAdmin($request, $next, $user);
        }

        return $this->handleNonAdmin($request, $next, $user);
    }

    private function handleAdmin(Request $request, Closure $next, $user): Response
    {
        $role = $user->active_role;
        if ($role === null || $role === '') {
            $role = 'admin';
        }

        if ($role === 'admin') {
            if ($request->routeIs('admin.*')) {
                return $next($request);
            }

            return redirect()->route('admin.dashboard');
        }

        if ($role === 'buyer') {
            if ($request->routeIs('account.*', 'buyer.*', 'seller.*')) {
                return $next($request);
            }

            if ($request->routeIs('admin.dashboard')) {
                return $next($request);
            }

            return redirect()->route('account.dashboard');
        }

        if ($role === 'seller') {
            if ($request->routeIs('account.*', 'buyer.*', 'seller.*')) {
                return $next($request);
            }

            if ($request->routeIs('admin.dashboard')) {
                return $next($request);
            }

            return redirect()->route('account.dashboard');
        }

        return redirect()->route('admin.dashboard');
    }

    private function handleNonAdmin(Request $request, Closure $next, $user): Response
    {
        return $next($request);
    }
}
