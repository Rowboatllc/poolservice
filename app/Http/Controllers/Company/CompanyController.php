<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Auth;
use App\Common\Common;

use App\Repositories\CompanyRepositoryInterface;

class CompanyController extends Controller {

    private $user;

    public function __construct(UserRepository $user, CompanyRepositoryInterface $company) 
    {
        $this->user = $user;
        $this->company = $company;
    }

    public function index() 
    {
        $user = Auth::user();
        $customers = $this->company->getCustomers($user->id);
        $offers = $this->company->getServiceOffers($user->id);
        $comProfile=$this->user->getCompanyProfile($user->id);
        $technicianRepo = new \App\Repositories\TechnicianRepository;
        $technicians = $technicianRepo->getList($user->id);
        $routes=$this->user->getUserSchedule($user->id);
        $user=$this->user->getUserInfo($user->id);
        // dd(Common::getDateOfWeekDay('Thursday'));
        return view('company.index', compact(['customers', 'offers', 'technicians','comProfile','routes','user']));
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
}