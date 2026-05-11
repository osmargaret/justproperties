<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveRoleSelected
{
    /**
     * Admins with active_role admin: admin routes only.
     * Admins with active_role buyer|seller: that workspace only; other admin pages redirect to admin dashboard.
     * Non-admins: buyer or seller workspace per active_role (see handleNonAdmin).
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
            if ($request->routeIs('buyer.*')) {
                return $next($request);
            }

            if ($request->routeIs('admin.dashboard')) {
                return $next($request);
            }

            return redirect()->route('buyer.dashboard');
        }

        if ($role === 'seller') {
            if ($request->routeIs('seller.*')) {
                return $next($request);
            }

            if ($request->routeIs('admin.dashboard')) {
                return $next($request);
            }

            return redirect()->route('seller.dashboard');
        }

        return redirect()->route('admin.dashboard');
    }

    private function handleNonAdmin(Request $request, Closure $next, $user): Response
    {
        if ($user->active_role === null || $user->active_role === '') {
            if ($request->routeIs('buyer.dashboard', 'seller.dashboard')) {
                return $next($request);
            }

            return redirect()->route('home');
        }

        if ($user->active_role === 'buyer') {
            if ($request->routeIs('buyer.*')) {
                return $next($request);
            }

            return redirect()->route('buyer.dashboard');
        }

        if ($user->active_role === 'seller') {
            if ($request->routeIs('seller.*')) {
                return $next($request);
            }

            return redirect()->route('seller.dashboard');
        }

        return $next($request);
    }
}
