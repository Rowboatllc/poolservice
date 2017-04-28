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
use App\Repositories\NotificationRepositoryInterface;
use App\Http\Requests\TechnicianRequest;

class TechnicianController extends Controller {

    protected $user;
    protected $company;
    protected $schedule;
    protected $common;
    protected $notification;

    public function __construct(UserRepository $user,ScheduleRepositoryInterface $schedule, CompanyRepositoryInterface $company, NotificationRepositoryInterface $notification) 
    {
        $this->user = $user;
        $this->schedule = $schedule;
        $this->company = $company;        
        $this->notification = $notification;
        $this->common = app('App\Common\Common');
    }

    public function index() 
    {
        $user = Auth::user();
        $company = $this->company->getCompanyProfile($user->id);
        $schedules = $this->schedule->getAllScheduleInWeek($user->id);
        return view('technician.index',compact(['user', 'schedules', 'company']));
    }

    public function enroute($schedule_id) 
    {
        try{
            $schedule = $this->schedule->updateStatus($schedule_id, 'checkin');            
            $user = $this->schedule->getPoolownerInSchedule($schedule_id);
            if (isset($user) && $schedule) {
                $content = 'Technician is on the way';
                Mail::send('emails.technician-enroute', compact('user'), function($message)
                        use ($user, $content) {
                    $message->subject($content);
                    $message->to($user->email);
                });
                $this->notification->saveNotification($user->id, $content, false);
            }
            return $this->common->responseJson(true);
        }
        catch(\Exception $e){
            return $this->common->responseJson(false);
        }
    }

    public function completeSteps(Request $request) 
    {
        $result = $this->schedule->updateSchedule($request->all(), 'complete');
        return $this->common->responseJson($result);
    }

    public function unableSteps(Request $request) 
    {
        $result = $this->schedule->updateSchedule($request->all(), 'unable');
        return $this->common->responseJson($result);        
    }

    
}
