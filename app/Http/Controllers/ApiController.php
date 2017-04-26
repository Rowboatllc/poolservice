<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ApiController extends Controller {

    protected $common;

    public function __construct() {
        $this->common = app('App\Common\Common');
    }

    public function uploadImage($folder) {
        $result = $this->common->uploadResizeImage($folder);
        if ($result)
            return $this->common->responseJson(true, 200, '', ['path' => $result]);
        return $this->common->responseJson(false);
    }

}
