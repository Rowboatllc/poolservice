<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\LoginRequest;
use Auth;
use App\Models\User;
use Mail;

class CompanyController extends Controller {

    private $user;

    public function __construct(UserRepository $user) 
    {
        $this->user = $user;
    }

    public function index() 
    {
        return view('company.index');
    }

    public function addCompanyProfile(Request $request) 
    {
        $user=Auth::user();
        $company=$this->user->updateCompanyProfile($request->all(),$user->id);
        if($company)
        {
            $logo=$request['logo'];
            $wq=$request['wq'];
            $cpa=$request['cpa'];
            $driver_license=$request['driver_license'];
            
            if($logo)
            {
                $logoCom=$logo->getClientOriginalName();                
                $logo->storeAs('company-profile',$logoCom);
            }

            if($wq)
            {
                $logoWq=$wq->getClientOriginalName();                
                $wq->storeAs('company-profile',$logoWq);
            }

            if($driver_license)
            {
                $logoDriver_license=$driver_license->getClientOriginalName();
                $driver_license->storeAs('company-profile',$logoDriver_license);
            }

            if($cpa)
            {
                $logoCpa=$cpa->getClientOriginalName();
                $cpa->storeAs('company-profile',$logoCpa);
            }

            return response()->json(['success' => true,'message' => $company],200);
        }
        else
        {
            return response()->json(['success' => false,'message' => 'error occured in system !!!'],200);
        }        
    }
}
