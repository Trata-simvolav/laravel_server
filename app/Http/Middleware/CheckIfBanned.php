<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->isBanned()) {
            return response()->json([
                'error' => 'User is banned.'
            ], Response::HTTP_FORBIDDEN); // HTTP 403 Forbidden
        }

        return $next($request);
    }
}
