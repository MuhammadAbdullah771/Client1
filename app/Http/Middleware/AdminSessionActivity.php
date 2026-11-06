<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminSessionActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $guard = Auth::guard('admin');

        if ($guard->check()) {
            $lastActivity = (int) $request->session()->get('admin_last_activity', time());
            $lifetimeSeconds = (int) config('session.lifetime', 480) * 60;
            $expired = (time() - $lastActivity) > $lifetimeSeconds;

            if ($expired) {
                $guard->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')
                    ->with('error', 'Your session has expired. Please sign in again.');
            }

            // Refresh last activity timestamp on every request
            $request->session()->put('admin_last_activity', time());
        }

        return $next($request);
    }
}
