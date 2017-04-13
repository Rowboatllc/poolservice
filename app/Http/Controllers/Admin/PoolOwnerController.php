<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Common\ZipcodeState;
use App\Repositories\ApiToken;
use Illuminate\Http\Request;
use Auth;

use App\Models\User;

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
        $result = \App\Models\Profile::find($id);
        return $result;
    }
    
    public function saveProfile( Request $request) {
        $user = $this->getUserByToken();
        if($request->file('avatar'))
           $this->uploadFile();
        $profile = \App\Models\Profile::find($user->id);
        $profile->fullname = $request->input('fullname');
        $profile->zipcode = $request->input('zipcode');
        $profile->city = $request->input('city');
        $profile->address = $request->input('address');
        $profile->state = $request->input('state');
        $profile->zipcode = $request->input('zipcode');
        $profile->phone = $request->input('phone');
        if( $request->input('avatar') )
            $profile->avatar = $request->input('avatar');
        $result = $profile->save();
        return response()->json(['returnValue' => $result]);
    }
    
    public function getUserByToken() {
        $api = new ApiToken;
        return $api->getUserByToken();
    }
    
    public function saveAvatar(Request $request)
    {
        $avatarFolder = 'public/uploads/profile';
        $file = $request->file('avatar');
        //$user = $this->getUserByToken();
        $user = \App\Models\User::find(4);
        $profile = \App\Models\Profile::find($user->id);
        $extension = $file->extension();
        
        if (!($file->isValid() && $extension!='exe' && in_array($extension, ['jpg', 'png'])))
            return response()->json(['error'=>'File is invalid']);
            
        $profile->avatar = $file->storeAs($avatarFolder, md5($user->email) . '.' . $extension);
        $result = $profile->save();
        return response()->json([
            'returnValue' => $result,
            'path' => '/uploads/profile/'.md5($user->email) . '.' . $extension
        ]);
    }
    
}
