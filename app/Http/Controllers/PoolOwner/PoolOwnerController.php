<?php

namespace App\Http\Controllers\PoolOwner;

use Illuminate\Http\Request;
use App\Repositories\PageRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PoolOwnerController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    protected $company;

    public function __construct(PageRepositoryInterface $page, CompanyRepositoryInterface $company)
    {
       parent::__construct($page);
       $this->company = $company;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->loadHeadInPage('home');
        $user_id = Auth::id();
        $companys = $this->company->getSelectedCompany($user_id);
        $point = 0;
        if(!isset($companys)||empty($companys)){
            $company_id = 0;
            $companys = $this->company->getAllCompanySupportOwner($user_id);
        }else{
            $company_id = $companys[0]->id;
            $point = $this->company->getRatingCompany($user_id, $company_id);
        }
        return view('poolowner.index', compact(['companys','company_id','point']));
        
    }

    public function started(){
        $this->loadHeadInPage('home');
        return view('started');
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
        
        $user_id = Auth::id();
        $result = $this->company->saveRatingCompany($user_id, $company_id, $point);
        return redirect()->route('poolowner');
    }


}
