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

    public function poolOwnerIndex()
    {
        return view('pool-owner');
    }

    public function poolServiceIndex()
    {
        $zipcodes=$this->user->getListZipcode();
        return view('pool-service',compact(['zipcodes']));
    }

    public function addNewPoolOwner(Request $request)
    {
        //set confirmation_code to request
        $confirmation_code = str_random(30);
        $request['confirmation_code']=$confirmation_code;
        // passed validation then save user to database	
        $pool=$request->all();
        $val=$this->user->AddNewPoolOwnerSubscriber($pool);
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
            try {
                //send email to verify user password_hash
                Mail::send('emails.verify', compact('confirmation_code','email'), function($message) 
                use ($request,$email)
                {     
                    $message->subject('Authentication your new account');
                    $message->to($email, $request['fullname']);
                });
                print_r(error_get_last());
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }            

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
        if(count($val)<=0)
        {
            return response()->json('');
        }else{
            return response()->json('true');
        }        
    }

    public function addEmailNotify(Request $request)
    {
        $user=$this->user->addEmailNotify($request['not-exist-email']);
        return redirect('register/pool-owner-register');    
    }
}
