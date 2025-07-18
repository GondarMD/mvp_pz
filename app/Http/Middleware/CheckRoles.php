<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
       // Check if the user has the required role
        if (!$request->user()->hasRole($role)) {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
