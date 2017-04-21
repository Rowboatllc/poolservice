<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Repositories\ApiToken as MyToken;

class ApiToken {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        $token = new MyToken;
        //$authenticated = $token->isValid();
        if (!$token->isValid() || !$request->ajax()) {
            $response = response()->json([
                        'success' => false,
                        'message' => 'Not authenticated',
                        'code' => 401], 401
            );
            $response->header('Content-Type', 'application/json');
            return $response;
        }
        return $next($request);
    }
    
    

}
