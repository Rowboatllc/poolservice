<?php

namespace App\Http\Controllers\PoolOwner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BillingInfoRepositoryInterface;
use App\Repositories\OrderRepository;
use Auth;

class ApiPoolOwnerController extends Controller {
    
    protected $billing;
    protected $common;
    protected $repoProfile;

    public function __construct(BillingInfoRepositoryInterface $billing) {
        $this->billing = $billing;
        $this->common = app('App\Common\Common');
        $this->repoProfile = app('App\Repositories\ProfileRepository');
    }

    public function uploadResizeAvatar() {
        $result = $this->repoProfile->uploadResizeAvatar('uploads/profile');
        if ($result)
            return $this->common->responseJson(true, 200, '', ['path' => $result]);
        return $this->common->responseJson(false);
    }
    
    public function saveNewEmail(Request $request) {        
        $user = Auth::user();
        return $this->common->responseJson($this->repoProfile->saveNewEmail($user->id, $request->all()));
    }

    public function saveNewPassword(Request $request) {
        $user = Auth::user();
        return $this->common->responseJson($this->repoProfile->saveNewPassword($user->id, $request->all()));
    }

    public function saveProfile(Request $request) {
        $user = Auth::user();
        return $this->common->responseJson($this->repoProfile->saveProfile($user->id, $request->all()));
    }

    public function savePoolInfo(Request $request) {
        $order = new OrderRepository;
        $user = Auth::user();
        return $this->common->responseJson($order->savePoolInfo($user->id, $request->all()));
    }

}
