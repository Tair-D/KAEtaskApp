<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        if (!Auth::user() || !Auth::user()->hasRole($role)) {
            return response()->json(['message' => 'У вас недостаточно прав для доступа к данной странице.'],403);
        }

        return $next($request);

    }
}
