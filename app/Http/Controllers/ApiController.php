<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ApiController extends Controller {

    protected $common;
    protected $notification;

    public function __construct() {
        $this->common = app('App\Common\Common');
        $this->notification = app('App\Repositories\NotificationRepository');
    }

    public function uploadImage($folder) {
        $result = $this->common->uploadResizeImage($folder);
        if ($result)
            return $this->common->responseJson(true, 200, '', ['path' => $result]);
        return $this->common->responseJson(false);
    }
}
