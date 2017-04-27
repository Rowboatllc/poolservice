<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Repositories\AclRepository;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $id = Auth::user()->id;
            $acl = new AclRepository;
            $group = $acl->getUserGroup($id);
            if(isset($group))
                return redirect()->route($group);
            else
                return redirect('/page-not-found');
        }
        return $next($request);
    }
}
