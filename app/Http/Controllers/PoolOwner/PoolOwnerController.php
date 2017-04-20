<?php

namespace App\Http\Controllers\PoolOwner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Common\ZipcodeState;
use App\Repositories\ApiToken;
use Mail;

use App\Common\Common;
use App\Models\User;
use App\Models\Profile;
use App\Models\BillingInfo;

use App\Repositories\PageRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\BillingInfoRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\NotificationRepositoryInterface;

class PoolOwnerController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $company;
    protected $billing;
    protected $profile;
    protected $user;
    protected $notification;
    
    
    public function __construct(
        UserRepository $user, PageRepositoryInterface $page, CompanyRepositoryInterface $company, 
        BillingInfoRepositoryInterface $billing, NotificationRepositoryInterface $notification) {
        parent::__construct($page);
        $this->user = $user;        
        $this->company = $company;
        $this->billing = $billing;
        $this->profile = app('App\Models\Profile');
        $this->notification = $notification;
        
    }

    public function index(Request $request) {
        $this->loadHeadInPage('home');
        $user = Auth::user();
        $common = new Common;
        $tab = $request->input('tab');

        // profile
        $profile = $this->profile->find($user->id);
        if (!$profile) {
            $profile = $common->getDefaultEloquentAttibutes($this->profile);
        }
        //$profile->codes = $common->getListZipCode();
        $profile->email = $user->email;

        //Billing Info

        $billing_info = $this->billing->getBillingInfo($user->id);

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
        return view('poolowner.index', compact(['tab', 'companys','company_id','point', 'profile', 'billing_info']));
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
        if($result){
            $company = $this->company->getCompanyById($company_id);
            $content = 'Customers sign up for your service';
            Mail::send('emails.select-company', compact('company'), function($message) 
            use ($company, $content)
            {     
                    $message->subject($content);
                    $message->to($company->email);
            });
            $this->notification->saveNotification($company->user_id,$content,false);
            
        }

        return redirect()->route('poolowner',['tab' => "service_company"]);
    }

    public function selectNewCompany($company_id){
        $user_id = Auth::id();
        $result = $this->company->removeAllSelectCompany($user_id);
        if($result){
            $company = $this->company->getCompanyById($company_id);
            $content = 'Customers remove for your service';
            Mail::send('emails.remove-company', compact('company'), function($message) 
            use ($company, $content)
            {     
                    $message->subject($content);
                    $message->to($company->email);
            });
            $this->notification->saveNotification($company->user_id,$content,false);
        }
        return redirect()->route('poolowner',['tab' => "service_company"]);
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
    
    public function saveNewEmail(Request $request) {
        $obj = $this->getUserByToken();
        $obj = User::find($obj->id);
        $oldEmail = $obj->email;
        $email = $request->input('email');
        $result = false;
        if($obj->email != $email) {
            $obj->email = $email;
            try {
                $obj->save();
                $data = [
                    'email' => [$email, $oldEmail],
                    'subject' => 'Changed email',
                    'data' => []
                ];
                $common = new Common;
                $common->sendmail('emails.verifytpl', $data);
                $result = true;
            } catch (Exception $e) {
            }
        }
        return response()->json([
                    'success' => $result,
                    'message' => '',
                    'code' => 200], 200
        )->header('Content-Type', 'application/json');
    }
    
    public function saveNewPassword(Request $request) {
        $obj = $this->getUserByToken();
        $obj = User::find($obj->id);
        $result = false;
        $password = \Hash::make($request->input('password'));
        $newpwd = $request->input('new-password');
        $rewpwd = $request->input('re-password');
        //dd($obj->password,$password, $request->input('password'));
        if(($obj->password==$password) && ($newpwd==$rewpwd)) {
            $obj->password = $newpwd;
            $result = $obj->save();
        }
        return response()->json([
                    'success' => $result,
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

    public function updateBillingInfo(Request $request){
        $user = $this->getUserByToken();
        $result = $this->billing->updateBillingInfo($user->id, $request->all());

        return response()->json([
                    'error' => !$result,
                    'message' => '',
                    'code' => 200], 200
        )->header('Content-Type', 'application/json');
    }
}
