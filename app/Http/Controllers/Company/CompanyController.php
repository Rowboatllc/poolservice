<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;

use Illuminate\Http\Request;
use App\Common\Common;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\BillingInfoRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\PageRepositoryInterface;
use App\Repositories\ScheduleRepositoryInterface;

class CompanyController extends Controller {

    private $user;    
    protected $billing;
    protected $schedule;

    public function __construct(PageRepositoryInterface $page, UserRepository $user, 
    CompanyRepositoryInterface $company, BillingInfoRepositoryInterface $billing, ScheduleRepositoryInterface $schedule) 
    {
        parent::__construct($page);
        $this->user = $user;
        $this->company = $company;
        $this->billing = $billing;
        $this->schedule = $schedule;
    }

    public function index() 
    {
        $user = Auth::user();
        $offers = $this->company->getServiceOffers($user->id);
        //$customers = $this->company->getCustomers($user->id);
        //$offerFromPoolowner = $this->company->getOfferFromPoolowner($user->id);
        //$technicians = $technicianRepo->getList($user->id);
        
        $comProfile=$this->user->getCompanyProfile($user->id);
        $technicianRepo = new \App\Repositories\TechnicianRepository;
        
        $user=$this->user->getUserInfo($user->id);
        $currentDate=Common::getCurrentDay(new Datetime()); 
        $currentMonthYear=Common::getCurrentDayYear(new Datetime());
        $dates=$this->schedule->getUserSchedule($user->id);
        // dd($dates);
        $scheduleNotAsign=$this->schedule->getAllPoolownerNotAssigned($user->id);
        $listTechnicians = $this->user->getListTechnician($user->id);
        $daysOfWeekMonth=$this->schedule->getDayWeeksOfMonth($user->id,date('m'),date('Y'));
        //Billing Info
        $billing_info = $this->billing->getBillingInfo($user->id);
        // Get number of notifications
        $this->getNumberOfNotification();

        //check company is a technician
        $checkTechnician = $this->company->checkUserIsCompanyAsTechnician($user->id);

        return view('company.index', 
            compact([ 'checkTechnician', 'offers', 'comProfile','user','dates','currentDate','listTechnicians','billing_info','daysOfWeekMonth','currentMonthYear','scheduleNotAsign']));
    }

    public function addCompanyProfile(Request $request) 
    {
        $user=Auth::user();
        $company=$this->user->updateCompanyProfile($request->all(),$user->id);
        if($company)
        {
            $extension_logo = $request['logo']->extension();
            $extension_wq = $request['wq']->extension();
            $extension_cpa = $request['cpa']->extension();
            $extension_driver_license = $request['driven_license']->extension();
            $logo=$request['logo'];
            $wq=$request['wq'];
            $driver_license=$request['driven_license'];
            $cpa=$request['cpa'];
            if ((!$logo->isValid() || $extension_logo=='exe' || !in_array($extension_logo, ['jpg', 'png']))
                ||(!$wq->isValid() && $extension_wq=='exe' && !in_array($extension_logo, ['jpg', 'png']))
                ||(!$cpa->isValid() && $extension_cpa=='exe' && !in_array($extension_logo, ['jpg', 'png']))
                ||(!$driver_license->isValid() || $extension_driver_license=='exe' || !in_array($extension_logo, ['jpg', 'png']))
            )
            {
                //logo
                $logoCom=$logo->getClientOriginalName();     
                $logo->move(public_path().'/company-image/',$logoCom);
                //wq
                $logoWq=$wq->getClientOriginalName();   
                $wq->move(public_path().'/company-image/',$logoWq); 
                //driver_license
                $logoDriver_license=$driver_license->getClientOriginalName();
                $driver_license->move(public_path().'/company-image/',$logoDriver_license);
                //cpa
                $logoCpa=$cpa->getClientOriginalName();
                $cpa->move(public_path().'/company-image/',$logoCpa);

                return response()->json(['success' => true,'message' => $company],200);
            }
            else
            {
                return response()->json(['success' => false,'message' => 'error occured in system !!!'],304);                
            }            
        }
        else
        {
            return response()->json(['success' => false,'message' => 'error occured in system !!!'],304);
        }        
    }

    public function loadPoolOwner(Request $request)
    {        
        $id=$request['id'];
        if($id=="") return;
        if(intval($id)<=0)
        {
            $user=Auth::user();
            $id=$user->id;
        }

        $date=$request['date'];
        $dates=Common::getDateInWeek(new Datetime(),6);
        $schedule=$this->schedule->getUserScheduleBetweenDate($id,$dates[$date],$dates[$date]);
        if($schedule)
        {
            return response()->json(['success' => true,'message' => $schedule],200);
        }
        else{
            return response()->json(['success' => false,'message' => 'error occured in system !!!'],304);
        }        
    }

    public function loadServiceLastMonth(Request $request)
    {        
        $date=$request['date'];
        $type=$request['type'];
        if($date=="" || $date=="") return;

        $arr=array();
        $id=Auth::user()->id;
        $dt=new DateTime('1 ' . $date);
        if($type==1){
            $lastDate=$dt->modify( 'last day of previous month' );
            $arr['date']=$lastDate->format('M Y');
            $schedule=$this->schedule->getDayWeeksOfMonth($id,$lastDate->format('m'),$lastDate->format('Y'));
        }else if($type==2){
            $lastDate=$dt->modify( 'last day of next month' );
            $arr['date']=$lastDate->format('M Y');
            $schedule=$this->schedule->getDayWeeksOfMonth($id,$lastDate->format('m'),$lastDate->format('Y'));
        }
        if($schedule)
        {
            $arr['schedule']=$schedule;
            return response()->json(['success' => true,'message' => $arr],200);
        }
        else{
            return response()->json(['success' => false,'message' => 'error occured in system !!!'],304);
        }      
    }

    public function changeTaskToNotAvailable(Request $request)
    {
        $id=$request['id'];
        $date=$request['date'];

        if($id=="" || $date=="") return;

        $dates=Common::getDateInWeek(new Datetime(),6);
        $val=$this->schedule->notAvailable($id,$dates[$date]);

        return response()->json(['success' => $val]);
    }
}