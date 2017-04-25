<?php

namespace App\Http\Controllers\PoolOwner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ApiToken;
use Mail;
use App\Common\Common;
use App\Models\User;
use App\Models\Profile;
use App\Models\Order;
use App\Repositories\PageRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\BillingInfoRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\NotificationRepositoryInterface;
use App\Repositories\OrderRepository;

//use App\Repositories\ProfileRepository;

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
    protected $notification;
    protected $repoProfile;

    public function __construct(
    UserRepository $user, PageRepositoryInterface $page, CompanyRepositoryInterface $company, BillingInfoRepositoryInterface $billing, NotificationRepositoryInterface $notification) {
        parent::__construct($page);
        $this->user = $user;
        $this->company = $company;
        $this->billing = $billing;
        $this->profile = app('App\Models\Profile');
        $this->common = app('App\Common\Common');
        $this->notification = $notification;
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

        //Billing Info
        $billing_info = $this->billing->getBillingInfo($user->id);

        // my pool service company
        $companys = $this->company->getSelectedCompany($user->id);
        $point = 0;
        if (empty($companys)) {
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

    public function selectCompany($company_id) {
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
        return redirect()->route('pool-owner', ['tab' => "service_company"]);
    }

    public function selectNewCompany($company_id) {
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
        return redirect()->route('pool-owner', ['tab' => "service_company"]);
    }

    public function ratingCompany(Request $request) {
        $point = $request->input('company_point');
        $company_id = $request->input('company_id');
        if (!isset($point) || $point == 0) {
            $point = 1;
        }
        $user_id = Auth::id();
        $result = $this->company->saveRatingCompany($user_id, $company_id, $point);
        return redirect()->route('pool-owner', ['tab' => "service_company"]);
    }

}
