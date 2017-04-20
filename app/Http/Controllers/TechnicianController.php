<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Mail;

use App\Repositories\UserRepository;

use App\Http\Requests\TechnicianRequest;

class TechnicianController extends Controller {

    private $user;

    public function __construct(UserRepository $user) 
    {
        $this->user = $user;
    }

    public function index() 
    {
        $tab=null;
        return view('technician.index',compact(['tab']));
    }

    
}
