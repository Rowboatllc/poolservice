<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Mail;

class RegisServiceController extends Controller
{
    private $user;
    public function __construct(UserRepository $user)
    {
        $this->user=$user;
    }

    public function index()
    {
        return view('poolservice');
    }

    public function addNewPoolService(Request $request)
    {
        //set confirmation_code to request
        $confirmation_code = str_random(30);
        $request['confirmation_code']=$confirmation_code;
        // passed validation then save user to database	
        $pool=$request->all();
        $val=$this->user->AddNewPoolServiceSubscriber($pool);
        $email=$request['email'];
        if($val)
        {
            //send email to verify user password_hash
            Mail::send('emails.verify', compact('confirmation_code','email'), function($message) 
            use ($request,$email)
            {     
                 $message->subject('Authentication your new account');
                 $message->to($email, $request['fullname']);
            });

            //register success and message to user 
            return response()->json(['success' => true,'message' => $email],200);
        }
        else
        {
            //register failed and message to user 
            return response()->json(['success' => false,'message' => 'error occurred in system !!!!'],422);
        } 
    }

    public function check_email_exists(Request $request)
    {   
        $val=$this->user->check_email_exist($request['email']);
        if($val===null)
        {
            return response()->json('true');
        }else{
            return response()->json('');
        }        
    }

    public function check_zipcode_exists(Request $request)
    {   
        $val=$this->user->check_zipcode_exist($request['zipcode']);
        if($val===null)
        {
            return response()->json('');
        }else{
            return response()->json('true');
        }        
    }


    public function addEmailNotify(Request $request)
    {
        // dd($request->all());
        $user=$this->user->addEmailNotify($request['not-exist-email']);
        if($user===null)
        {
            return redirect('user-regis-service');
        }else{
            return redirect('user-regis-service');
        }        
    }

    public function userConfirmService(Request $request,$token,$email)
    {
        return view('confirm-service',compact('email','token'));
    }

    public function doUserConfirmService(Request $request)
    {
        // validation input data         
        $rules = [
            'password' => 'required|min:6'
        ];

        $arr = $request->only('password', 'email');
        $validator = Validator::make($arr, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        // save user to database
        $val = $this->user->confirmPoolAccount($request->all());
        
        if ($val) {
            //register success and message to user 
            return redirect()->back()
                            ->with('success', $val);
        } else {
            //register failed and message to user 
            return redirect()->back()
                            ->with('error', $val);
        }
    }
}
