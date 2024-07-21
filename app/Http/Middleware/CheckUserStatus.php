<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = Auth::user();

        if ($user) {
            if ($role === 'admin' && $user->status === 'admin') {
                return $next($request);
            }

            if ($role === 'customer' && $user->status === 'customer') {
                return $next($request);
            }
        }

        return redirect('/login')->with('error', 'Access denied.');
    }
}
