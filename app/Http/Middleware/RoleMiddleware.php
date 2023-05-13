<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if ($role == 'shared' && $request->user()->roles()->whereIn('role_id', [Role::RELEASE_ADMIN, Role::OFFICE_STAFF])->exists()) {
            return $next($request);
        }
        if (!$request->user()->roles()->where('role_id', $role)->exists()) {
            session(['active_role' => $request->user()->roles()->first()?->id]);
            return redirect()->route('home');
        }
        session(['active_role' => $role]);
        return $next($request);
    }
}
