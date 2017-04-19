<?php

namespace App\Http\Controllers\PoolOwner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Common\ZipcodeState;
use App\Repositories\ApiToken;

use App\Common\Common;
use App\Models\User;
use App\Models\Profile;

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
    protected $profile;

    public function __construct(PageRepositoryInterface $page, CompanyRepositoryInterface $company, BillingInfoRepositoryInterface $billing) {
        parent::__construct($page);
        $this->company = $company;
        $this->billing = $billing;
        $this->profile = app('App\Models\Profile');
    }

    public function index() {
        $this->loadHeadInPage('home');
        $user = Auth::user();
        $common = new Common;

        // profile
        $profile = $this->profile->find($user->id);
        if (!$profile) {
            $profile = $common->getDefaultEloquentAttibutes($this->profile);
        }
        //$profile->codes = $common->getListZipCode();
        $profile->email = $user->email;

        //Billing Info

        $billing_info = $this->billing->getBillingInfo($user->id);
        $isEdit = true;

        // my pool service company
        $companys = $this->company->getSelectedCompany($user->id);
        $point = 0;
        if(!isset($companys)||empty($companys)){
            $company_id = 0;
            $companys = $this->company->getAllCompanySupportOwner($user->id);
        }else{
            $company_id = $companys[0]->id;
            $point = $this->company->getRatingCompany($user->id, $company_id);
        }
        return view('poolowner.index', compact(['companys','company_id','point', 'profile', 'billing_info', 'isEdit']));
        //return view('poolowner.index', compact(['companys','company_id','point', 'profile',  'isEdit']));
        
    }

    public function started() {
        $this->loadHeadInPage('home');
        return view('started');
    }

    public function _saveProfile(Request $request) {
        $user = $this->getUserByToken();
        $profile = $this->profile->find($user->id);
        if (!$profile)
            $profile = $this->profile;
        $profile->fullname = $request->input('fullname');
        $profile->zipcode = $request->input('zipcode');
        $profile->city = $request->input('city');
        $profile->address = $request->input('address');
        $profile->state = $request->input('state');
        $profile->zipcode = $request->input('zipcode');
        $profile->phone = $request->input('phone');
        $result = $profile->save();
        return response()->json(['returnValue' => $result]);
    }

    public function getUserByToken() {
        $api = new ApiToken;
        return $api->getUserByToken();
    }

    public function uploadResizeAvatar() {
        $common = new Common;
        $user = Auth::user();
        $result = $common->uploadResizeImage('uploads/profile');
        if ($result) {

            $profile = $this->profile->find($user->id);
            if ($profile) {
                $profile->avatar = $result;//$result['path'];
                $profile->save();
            } else {
                $data['user_id'] = $user->id;
                $data['avatar'] = $result;
                $this->profile->create($data);
            }
            return response()->json([
                    'error' => false,
                    'message' => '',
                    'path' => $result,
                    'code' => 200], 200
            )->header('Content-Type', 'application/json');
        }
        return response()->json([
                    'error' => false,
                    'message' => '',
                    'code' => 200], 200
        )->header('Content-Type', 'application/json');
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
    
    public function saveAccount(Request $request) {
        $obj = $this->getUserByToken();
        $obj = User::find($obj->id);
        $email = $request->input('email');
        $result = false;
        $password = \Hash::make($request->input('password'));
        if($obj->email != $email) {
            $obj->email = $email;
            $haveChange = true;
        }
        if($obj->password != \Hash::make($password)) {
            $obj->password = $password;
            $haveChange = true;
        }
        if(isset($haveChange)) {
            $obj->confirmation_code = str_random(30);
            $obj->status = 'pending';
            $result = $obj->save();
            if($result) {
                $info = [
                    'email' => $email,
                    'code' => $obj->confirmation_code
                ];
                $common = new Common;
                $common->verifyEmail($info);
            }
        }
        return response()->json([
                    'error' => $result,
                    'message' => '',
                    'code' => 200], 200
        )->header('Content-Type', 'application/json');
    }
    
    public function saveProfile(Request $request) {
        $obj = $this->getUserByToken();
        $obj = Profile::find($obj->id);
        $obj->fullname = $request->input('fullname');
        $obj->address = $request->input('address');
        $obj->state = $request->input('state');
        $obj->zipcode = $request->input('zipcode');
        $obj->city = $request->input('city');
        $result = $obj->save();
        return response()->json([
                    'error' => !$result,
                    'message' => '',
                    'code' => 200], 200
        )->header('Content-Type', 'application/json');
    }
    
    public function savePoolInfo(Request $request) {
        dd($request->all());
    }
}
