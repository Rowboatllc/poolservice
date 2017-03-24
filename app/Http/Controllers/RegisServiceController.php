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
        // dd($request->all());
        //set confirmation_code to request
        $confirmation_code = str_random(30);
        $request['confirmation_code']=$confirmation_code;
        // passed validation then save user to database	
        $pool=$request->all();
        $val=$this->user->AddNewPoolServiceSubscriber($pool);
        if($val)
        {
            //send email to verify user password_hash
            Mail::send('emails.verify', compact('confirmation_code'), function($message) 
            use ($request)
            {     
                 $message->subject('Authentication your new account');
                 $message->to($request['email'], $request['email']);
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
}
