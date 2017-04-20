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
use App\Models\Order;
use App\Repositories\PageRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\BillingInfoRepositoryInterface;
use App\Repositories\UserRepository;

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
    protected $common;

    public function __construct(UserRepository $user, PageRepositoryInterface $page, CompanyRepositoryInterface $company, BillingInfoRepositoryInterface $billing) {
        parent::__construct($page);
        $this->user = $user;
        $this->company = $company;
        $this->billing = $billing;
        $this->profile = app('App\Models\Profile');
        $this->common = app('App\Common\Common');
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
        $profile->email = $user->email;

        //Billing Info
        $billing_info = $this->billing->getBillingInfo($user->id);

        // my pool service company
        $companys = $this->company->getSelectedCompany($user->id);
        $point = 0;
        if (!isset($companys) || empty($companys)) {
            $company_id = 0;
            $companys = $this->company->getAllCompanySupportOwner($user->id);
        } else {
            $company_id = $companys[0]->id;
            $point = $this->company->getRatingCompany($user->id, $company_id);
        }
        return view('poolowner.index', compact(['tab', 'companys', 'company_id', 'point', 'profile', 'billing_info']));
    }

    public function started() {
        $this->loadHeadInPage('home');
        return view('started');
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
                $profile->avatar = $result;
                $profile->save();
            } else {
                $data['user_id'] = $user->id;
                $data['avatar'] = $result;
                $this->profile->create($data);
            }
            return $this->common->responseJson(false, 200, '', ['path' => $result]);
        }
        return $this->common->responseJson(false);
    }

    public function selectCompany($company_id) {
        $user_id = Auth::id();
        $result = $this->company->selectCompany($user_id, $company_id);
        if ($result) {
            $company = $this->company->getCompanyById($company_id);
            Mail::send('emails.select-company', compact('company'), function($message)
                    use ($company) {
                $message->subject('Customers sign up for your service');
                $message->to($company->email);
            });
        }

        return redirect()->route('poolowner', ['tab' => "service_company"]);
    }

    public function selectNewCompany($company_id) {
        $user_id = Auth::id();
        $result = $this->company->removeAllSelectCompany($user_id);
        if ($result) {
            $company = $this->company->getCompanyById($company_id);
            Mail::send('emails.remove-company', compact('company'), function($message)
                    use ($company) {
                $message->subject('Customers remove for your service');
                $message->to($company->email);
            });
        }
        return redirect()->route('poolowner', ['tab' => "service_company"]);
    }

    public function ratingCompany(Request $request) {
        $point = $request->input('company_point');
        $company_id = $request->input('company_id');
        if (!isset($point) || $point == 0) {
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
        if ($obj->email != $email) {
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
                return $this->common->responseJson($result);
            }
        }
        return $this->common->responseJson($result);
    }

    public function saveNewPassword(Request $request) {
        $obj = $this->getUserByToken();
        $obj = User::find($obj->id);
        $result = false;
        $password = $request->input('password');
        $newpwd = $request->input('new-password');
        $rewpwd = $request->input('re-password');
        if (\Hash::check($password, $obj->password)) {
            $obj->password = \Hash::make($newpwd);
            $result = $obj->save();
        }
        return $this->common->responseJson($result);
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
        return $this->common->responseJson($result);
    }

    public function savePoolInfo(Request $request) {
        $obj = $this->getUserByToken();
        $obj = Order::where('user_id', $obj->id)->first();
        $pool = $request->input('is-pool');
        $water = $request->input('watertype_weekly_pool');
        $obj->cleaning_object = $pool;
        if ($water)
            $obj->water = $water;
        return $this->common->responseJson($obj->save());
    }

    public function updateBillingInfo(Request $request) {
        $user = $this->getUserByToken();
        $result = $this->billing->updateBillingInfo($user->id, $request->all());
        return $this->common->responseJson($result);
    }

}
