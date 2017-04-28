<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Mail;

use App\Repositories\UserRepository;
use App\Repositories\ScheduleRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Http\Requests\TechnicianRequest;

class TechnicianController extends Controller {

    protected $user;
    protected $company;
    protected $schedule;
    protected $common;

    public function __construct(UserRepository $user,ScheduleRepositoryInterface $schedule, CompanyRepositoryInterface $company) 
    {
        $this->user = $user;
        $this->schedule = $schedule;
        $this->company = $company;
        $this->common = app('App\Common\Common');
    }

    public function index() 
    {
        $user = Auth::user();
        $company = $this->company->getCompanyProfile($user->id);
        $schedules = $this->schedule->getAllScheduleInWeek($user->id);
        return view('technician.index',compact(['user', 'schedules', 'company']));
    }

    public function enroute() 
    {
        $user = Auth::user();
        return $this->common->responseJson(true);
    }

    public function completeSteps() 
    {
        $user = Auth::user();
        return $this->common->responseJson($order->savePoolInfo($request->all()));
    }

    public function unableSteps() 
    {
        $user = Auth::user();
        return $this->common->responseJson($order->savePoolInfo($request->all()));
    }

    
}
