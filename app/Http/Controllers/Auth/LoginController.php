<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Repositories\AclRepository;
use Auth;
use App\Models\User;

use App\Repositories\UserRepository;
use App\Http\Requests\TechnicianRequest;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user) {
        $this->middleware('guest', ['except' => 'logout']);
        $this->user = $user;
    }

    protected function sendLoginResponse(Request $request) {
        $url = $this->redirectTo;
        $usertype = $this->getUserGroup();
        if(!empty($usertype))
            $url = route($usertype);
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        return $this->authenticated($request, $this->guard()->user())
                ? : redirect()->intended($url);
    }

    public function getUserGroup() {
        $id = Auth::user()->id;
        $acl = new AclRepository;
        return $acl->getUserGroup($id);
    }

    public function login(Request $request) {
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'status' => 'active',
        ];

        $data1 = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'status' => 'unclaimed',
        ];

        if (Auth::attempt($data)||Auth::attempt($data1)) {
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }


    public function verify($confirmCode) 
    {
        $user = $this->user->getUserByTocken($confirmCode);
        if(isset($user)){
            $email = $user->email;
            return view('technician.verify',compact(['email','confirmCode']));
        }else{
            return Redirect::to('/page-not-found'); 
        }
        
    }

    public function confirm(TechnicianRequest $request){
        $result = $this->user->confirmTechnicianAccount($request->all());
        if($result){
            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'status' => 'active',
            ];

            $data1 = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'status' => 'unclaimed',
            ];

            if (Auth::attempt($data)||Auth::attempt($data1)) {
                return $this->sendLoginResponse($request);
            }
        }
        return Redirect::to('/page-not-found'); 
    }

}
