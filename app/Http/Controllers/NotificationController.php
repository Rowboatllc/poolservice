<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class NotificationController extends Controller {

    protected $common;
    protected $notification;

    public function __construct() {
        $this->common = app('App\Common\Common');
        $this->notification = app('App\Repositories\NotificationRepository');
    }
    
    public function getList() {
        $user = Auth::user();
        $notifications = $this->notification->getList($user->id);
        //dd($notifications);
        return view('notification', compact(['notifications']));
    }
    
    public function listItems(Request $request) {
        $user = Auth::user();
        $result = $this->notification->listItems($user->id, $request->all());
        if ($result)
            return $this->common->responseJson(true, 200, '', ['list' => $result]);
        return $this->common->responseJson(false);
    }
    
     public function getItem(Request $request) {
        $user = Auth::user();
        $result = $this->notification->getItem($user->id, $request->all());
        if ($result)
            return $this->common->responseJson(true, 200, '', ['item' => $result]);
        return $this->common->responseJson(false);
    }
    
    public function updateItem(Request $request) {
        return $this->common->responseJson($this->notification->updateItem($request->all()));
    }
    
    public function removeItem(Request $request) {
        return $this->common->responseJson($this->notification->removeItem($request->all()));
    }
}
