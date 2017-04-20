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
use Illuminate\Support\Facades\DB;

class UserController extends Controller {

    private $user;

    public function __construct(UserRepository $user) 
    {
        $this->user = $user;
    }

    public function showLogin(Request $request,$token,$email) 
    {
        if(!empty($token))
        {
            $val = $this->user->confirmPoolAccount($token);
            if(is_null($val))
            {
                return Redirect::to('/page-not-found'); 
            }
        }

        return view('auth.login',compact('email'));
    }

    public function doLogin(Request $request) 
    {
        $user=$request->only('email', 'password');
        // check email and password is correct and actice
        $valid=$this->user->checkLogin($user);
        if($valid)
        {
            // validate login
            if (Auth::attempt($user)) {
                // login passed and navigate to home screen
                return redirect()->route('home');
            }
        }        

        // validation failed and redirect user to login again 
        return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors(['Email and/or password invalid.']);
    }
}
