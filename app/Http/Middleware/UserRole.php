<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Roles\UserRoles;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = false)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($role === false && !$user->hasAnyRole()) {
            return abort('403', "Сизда ушбу амалиёт учун етарли хукук мавжуд эмас");
        }

        if ($role !== false && !$user->hasRole(UserRoles::ROLE_DIRECTOR) && !$user->hasRole($role)) {
            return abort('403', "Сизда ушбу амалиёт учун етарли хукук мавжуд эмас");
        }

        return $next($request);
    }
}
