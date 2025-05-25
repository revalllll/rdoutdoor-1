<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = auth()->user();
        if (!$user || !$user->role || !in_array($user->role->name, $roles)) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}