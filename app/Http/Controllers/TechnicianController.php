<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Mail;

use App\Repositories\UserRepository;
use App\Repositories\CompanyRepositoryInterface;
use App\Http\Requests\TechnicianRequest;

class TechnicianController extends Controller {

    protected $user;
    protected $company;

    public function __construct(UserRepository $user,CompanyRepositoryInterface $company) 
    {
        $this->user = $user;
        $this->company = $company;
    }

    public function index() 
    {
        $user = Auth::user();
        $company = $this->company->getCompanyProfile($user->id);
        return view('technician.index',compact(['user','company']));
    }

    
}
