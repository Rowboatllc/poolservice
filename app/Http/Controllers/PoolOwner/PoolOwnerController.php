<?php

namespace App\Http\Controllers\PoolOwner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Common\ZipcodeState;
use App\Repositories\ApiToken;
use Image;

use App\Repositories\PageRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\BillingInfoRepositoryInterface;

class PoolOwnerController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $company;
    protected $billing;

    public function __construct(PageRepositoryInterface $page, CompanyRepositoryInterface $company, BillingInfoRepositoryInterface $billing) {
        parent::__construct($page);
        $this->company = $company;
        $this->billing = $billing;
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->loadHeadInPage('home');
        $user_id = Auth::id();

        // profile
        $profile = $this->getProfile();
        $code = new ZipcodeState;
        $profile->codes = $code->getListZipCode();
        $profile->email = Auth::user()->email;

        //Billing Info

        $billing_info = $this->billing->getBillingInfo($user_id);
        $isEdit = true;

        // my pool service company
        $companys = $this->company->getSelectedCompany($user_id);
        $point = 0;
        if(!isset($companys)||empty($companys)){
            $company_id = 0;
            $companys = $this->company->getAllCompanySupportOwner($user_id);
        }else{
            $company_id = $companys[0]->id;
            $point = $this->company->getRatingCompany($user_id, $company_id);
        }
        return view('poolowner.index', compact(['companys','company_id','point', 'profile', 'billing_info', 'isEdit']));
        
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

    public function selectCompany($company_id){
        $user_id = Auth::id();
        $result = $this->company->selectCompany($user_id,$company_id);
        return redirect()->route('poolowner');
    }

    public function selectNewCompany(){
        $user_id = Auth::id();
        $result = $this->company->removeAllSelectCompany($user_id);
        return redirect()->route('poolowner');
    }

    public function ratingCompany(Request $request){
        $point = $request->input('company_point');
        $company_id = $request->input('company_id');
        if(!isset($point)||$point==0){
            $point = 1;
        }
        $user_id = Auth::id();
        $result = $this->company->saveRatingCompany($user_id, $company_id, $point);
        return redirect()->route('poolowner');
    }
}
