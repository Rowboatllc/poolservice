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
            /*$permission = $request->route()->getName();
            $user = Auth::user();
            if ($user == null) {
                return redirect('/');
            }
            if ($permission == null) {
                dd('@dev: not set route name yet');
            }
            $id = Auth::user()->id;

            $user = User::find($id);
            $permission = AclRepository::userHasPermission($user, $permission);
            if (!$permission)
                return redirect(route('home'));*/
            return $next($request);
        }
    }

}
