<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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
                 $message->to($email, $email);
            });

            //register success and message to user 
            return redirect()->back()
                ->with('success', $val);
        }
        else
        {
            //register failed and message to user 
            return redirect()->back()
                ->with('error', $val);
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

    public function userConfirmService(Request $request)
    {
        dd($request->all());
        return view('confirm-service');
    }
}
