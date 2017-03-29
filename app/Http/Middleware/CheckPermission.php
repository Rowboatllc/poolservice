<?php

namespace App\Http\Middleware;

use App\Repositories\AclRepository;
use Auth;
use Closure;

class CheckPermission {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) { {
            $route = $request->route()->getName();
            if (!isset($route)) {
                dd('@dev: not set route name yet');
            }
            $user = Auth::user();
            $hasPermission = AclRepository::userHasPermission($user->id, $route);
            if (!$hasPermission)
                dd("You don't have permission!");
            return $next($request);
        }
    }

}
