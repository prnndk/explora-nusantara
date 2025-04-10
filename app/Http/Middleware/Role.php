<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $role = UserRole::tryFrom($role);
        if (!$role) {
           throw new \InvalidArgumentException('Invalid role provided.');
        }
        
        if ($request->user() && $request->user()->role !== $role) {
            abort(403,'You do not have permission to access this page.');
        }
        
        return $next($request);
    }
}