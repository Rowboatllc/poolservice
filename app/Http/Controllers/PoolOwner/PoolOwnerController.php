<?php

namespace App\Http\Controllers\PoolOwner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mail;

use App\Repositories\PageRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\BillingInfoRepositoryInterface;
use App\Repositories\NotificationRepositoryInterface;
use App\Repositories\ScheduleRepositoryInterface;
use App\Repositories\OrderRepository;

class PoolOwnerController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $company;
    protected $billing;
    protected $profile;
    protected $common;
    protected $notification;
    protected $repoProfile;
    protected $schedule;

    public function __construct(
            PageRepositoryInterface $page, CompanyRepositoryInterface $company, BillingInfoRepositoryInterface $billing, 
            NotificationRepositoryInterface $notification, ScheduleRepositoryInterface $schedule) {
        parent::__construct($page);
        $this->company = $company;
        $this->billing = $billing;
        $this->notification = $notification;
        $this->schedule = $schedule;
        $this->profile = app('App\Models\Profile');
        $this->common = app('App\Common\Common');
        $this->repoProfile = app('App\Repositories\ProfileRepository');
    }

    public function index(Request $request) {
        $this->loadHeadInPage('home');
        $user = Auth::user();
        $tab = $request->input('tab');

        // profile
        $profile = $this->profile->find($user->id);
        if (!$profile) {
            $profile = $this->common->getDefaultEloquentAttibutes($this->profile);
        }
        $profile->email = $user->email;
        
        $orderRepo = new OrderRepository;
        $poolinfo = $orderRepo->getPoolInfo($user->id);
        
        //Billing Info
        $billing_info = $this->billing->getBillingInfo($user->id);
        
        // my pool service company
        $companys = $this->company->getAllCompanySupportOwner($user->id);
        $company_select_arr = $this->company->getSelectedCompany($user->id);
        $point = 0;
        $company_select = null;
        if (!empty($company_select_arr)) {
            $company_select = $company_select_arr[0];
            $point = $this->company->getRatingCompany($user->id, $company_select->id);
        }
        $schedules = $this->schedule->getAllScheduleByPoolowner($user->id);
        return view('poolowner.index', compact(['tab', 'companys', 'company_select', 'point', 'profile', 'billing_info','schedules','poolinfo']));
    }

    public function started() {
        $this->loadHeadInPage('home');
        return view('started');
    }

    public function selectCompany($company_id) {
        try{
            $user_id = Auth::id();
            $result = $this->company->selectCompany($user_id, $company_id);
            if ($result) {
                $company = $this->company->getCompanyById($company_id);
                $content = 'Customers sign up for your service';
                Mail::send('emails.select-company', compact('company'), function($message)
                        use ($company, $content) {
                    $message->subject($content);
                    $message->to($company->email);
                });
                $this->notification->saveNotification($company->user_id, $content, false);
            }
            return $this->common->responseJson(true);
        }catch(\Exception $e){
            return $this->common->responseJson(false);
        }
    }

    public function selectNewCompany($company_id) {
        try{
            $user_id = Auth::id();
            $result = $this->company->removeAllSelectCompany($user_id);
            if ($result) {
                $company = $this->company->getCompanyById($company_id);
                $content = 'Customers remove for your service';
                Mail::send('emails.remove-company', compact('company'), function($message)
                        use ($company, $content) {
                    $message->subject($content);
                    $message->to($company->email);
                });
                $this->notification->saveNotification($company->user_id, $content, false);
            }
            return $this->common->responseJson(true);
        }catch(\Exception $e){
            return $this->common->responseJson(false);
        }
    }

    public function ratingCompany(Request $request) {
        try{
            $point = $request->input('company_point');
            $company_id = $request->input('company_id');
            if (!isset($point) || $point == 0) {
                $point = 1;
            }
            $user_id = Auth::id();
            $this->company->saveRatingCompany($user_id, $company_id, $point);
            return $this->common->responseJson(true);
        }catch(\Exception $e){
            return $this->common->responseJson(false);
        }
    }

    public function updateBillingInfo(Request $request) {
        $user_id = Auth::id();
        $result = $this->billing->updateBillingInfo($user_id, $request->all());
        return $this->common->responseJson($result);
    }

    public function getPointRatingCompany($company_id){
        $user_id = Auth::id();
        $point = $this->company->getRatingCompany($user_id, $company_id);
        return $this->common->responseJson(true, 200, '', ['point'=>$point]);        
    }

}
