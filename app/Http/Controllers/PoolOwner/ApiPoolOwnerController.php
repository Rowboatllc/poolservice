<?php

namespace App\Http\Controllers\PoolOwner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BillingInfoRepositoryInterface;
use App\Repositories\OrderRepository;

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
        return $this->common->responseJson($this->repoProfile->saveNewEmail($request->all()));
    }

    public function saveNewPassword(Request $request) {
        return $this->common->responseJson($this->repoProfile->saveNewPassword($request->all()));
    }

    public function saveProfile(Request $request) {
        return $this->common->responseJson($this->repoProfile->saveProfile($request->all()));
    }

    public function savePoolInfo(Request $request) {
        $order = new OrderRepository;
        return $this->common->responseJson($order->savePoolInfo($request->all()));
    }

    public function updateBillingInfo(Request $request) {
        $user = $this->common->getUserByToken();
        $result = $this->billing->updateBillingInfo($user->id, $request->all());
        return $this->common->responseJson($result);
    }

}
