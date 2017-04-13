<?php

namespace App\Http\Controllers\PoolOwner;

use Illuminate\Http\Request;
use App\Repositories\PageRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Common\ZipcodeState;
use App\Repositories\ApiToken;
use Image;

class PoolOwnerController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $company;

    public function __construct(PageRepositoryInterface $page, CompanyRepositoryInterface $company) {
        parent::__construct($page);
        $this->company = $company;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->loadHeadInPage('home');
        $user_id = Auth::id();
        $companys = $this->company->getAllCompanySupportOwner($user_id);
        // profile
        $profile = $this->getProfile();
        $code = new ZipcodeState;
        $profile->codes = $code->getListZipCode();
        $profile->email = Auth::user()->email;

        return view('poolowner.index', compact(['companys', 'profile']));
    }

    public function started() {
        $this->loadHeadInPage('home');
        return view('started');
    }

    public function getProfile() {
        $id = Auth::user()->id;
        $result = \App\Models\Profile::find($id);
        return $result;
    }

    public function saveProfile(Request $request) {
        $user = $this->getUserByToken();
        $profile = \App\Models\Profile::find($user->id);
        $profile->fullname = $request->input('fullname');
        $profile->zipcode = $request->input('zipcode');
        $profile->city = $request->input('city');
        $profile->address = $request->input('address');
        $profile->state = $request->input('state');
        $profile->zipcode = $request->input('zipcode');
        $profile->phone = $request->input('phone');
        if ($request->input('avatar'))
            $profile->avatar = $request->input('avatar');
        $result = $profile->save();
        return response()->json(['returnValue' => $result]);
    }

    public function getUserByToken() {
        $api = new ApiToken;
        return $api->getUserByToken();
    }

    public function uploadResizeAvatar(Request $request) {
        $avatarFolder = 'uploads/profile';
        $file = $request->file('avatar');
        $user = Auth::user();
        $extension = $file->extension();
        if (!($file->isValid()) || $extension == 'exe' || !in_array($extension, ['jpg', 'png', 'jpeg'])) {
            return response()->json(['error' => 'File is invalid']);
        }
        $image_name = md5($user->email) . '.' . $extension;
        //resize
        //$result = Image::make($avatarFolder.'/'.$image_name)->resize(100, 100)->save($avatarFolder.'/'.$image_name);

        $result = $file->storeAs($avatarFolder, $image_name);
        response()->json([
            'returnValue' => $result,
            'path' => $avatarFolder . '/' . $image_name
        ]);
    }

}
