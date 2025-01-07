<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // By Amnat

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {

        // Ensure the user is authenticated By Amnat
        if (!Auth::check()) {
            return redirect('/signin'); // Redirect to login if not logged in
        }

        // Check if the user has the required role By Amnat
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized'); // Abort with a 403 error if unauthorized
        }

        return $next($request);
    }
}
