<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureAdminAccess
{
    /**
     * Handle an incoming request - verify the secret admin path.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $secretPath = config('app.admin_secret_path', 'secure-admin-9a2024');
        
        // Check if the request path starts with the secret admin path
        if (!$request->is($secretPath) && !$request->is($secretPath . '/*')) {
            // If not authenticated and trying to access admin without secret path, abort
            if (!auth()->check() && $request->is('admin/*')) {
                abort(404);
            }
        }
        
        return $next($request);
    }
}