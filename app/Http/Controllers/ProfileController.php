<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller {

    protected $repo;

    public function __construct() 
    {
        $this->repo = app('App\Repositories\ProfileRepository');
        $this->common = app('App\Common\Common');
    }

    public function getCurrentUserInfo() {
        $result = $this->repo->getCurrentUserInfo();
        return $this->common->responseJson(true, 200, '', ['item' => $result]);
    }
    
}
