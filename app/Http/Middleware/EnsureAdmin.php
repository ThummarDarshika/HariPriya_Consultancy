<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Your admin session has expired. Please log in again before saving.',
                ], 401);
            }

            return redirect()->route('login')->with('admin-auth-required', true);
        }

        abort_unless($request->user()->is_admin, 403);

        return $next($request);
    }
}
