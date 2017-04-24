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
        return response()->json(['success' => true,'message' => $email],200);
    }
}
