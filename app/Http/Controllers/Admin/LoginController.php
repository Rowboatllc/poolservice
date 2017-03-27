<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ApiToken as ApiToken;
use Request;

class LoginController extends Controller {

    public function __construct() {
        
    }

    public function index() {
        return view('admin.login');
    }

    public function doLogin() {
        $tk = new ApiToken;
        $result = $tk->create();
        if ($result)
            return response()->json(["api_token" => $result->api_token]);
        return response()->json([
                    'error' => true,
                    'message' => 'can not login']
        );
    }

}
