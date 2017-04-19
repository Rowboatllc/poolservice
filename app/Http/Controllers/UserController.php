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

    public function showLogin(Request $request) 
    {
        return view('auth.login');
    }

    public function doLogin(Request $request) 
    {
        // validate login
        if (Auth::attempt($request->only('email', 'password'))) {
            // login passed and navigate to home screen
            return redirect()->route('home');
        }

        // validation failed and redirect user to login again 
        return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors(['Email and/or password invalid.']);
    }
}
