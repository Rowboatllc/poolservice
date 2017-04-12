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
        $companys = $this->company->getAllCompanySupportOwner($user_id);
        return view('poolowner.index', compact(['companys']));
    }

    public function started(){
        $this->loadHeadInPage('home');
        return view('started');
    }

}
