<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Common\ZipcodeState;
use App\Repositories\ApiToken;

class PoolOwnerController extends Controller {
    public function index() {
        $profile = $this->getProfile();
        $code = new ZipcodeState;
        $profile->codes = $code->getListZipCode();
        $profile->email = Auth::user()->email;
        return view('admin.poolowner')->with('profile', $profile);
    }
    
    public function getProfile() {
        $id = Auth::user()->id;
        $result = \App\Models\Profiles::find($id);
        return $result;
    }
    
    public function saveProfile( Request $request) {
        $api = new ApiToken;
        $user = $api->getUserByToken();
        //$data = Request::all();
        $profile = \App\Models\Profiles::find($user->id);
        $profile->fullname = $request->input('fullname');
        dd( $profile->fullname );
        $profile->zipcode = Request::input('zipcode');
        $profile->city = Request::input('city');
        $profile->address = Request::input('address');
        $profile->state = Request::input('state');
        $profile->zipcode = Request::input('zipcode');
        $profile->phone = Request::input('phone');
        //$profile->avatar = Request::input('avatar');
        
        $result = $profile->save();
        return response()->json(['returnValue' => $result]);
    }
    
    public function getUserByToken($token) {
        $api = new ApiToken;
        return $api->getUserByToken();
    }
}
