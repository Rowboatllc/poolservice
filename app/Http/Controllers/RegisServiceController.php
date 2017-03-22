<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Models\User;

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

    public function AddNewPoolService(Request $request)
    {
        dd($request->all());
        //set confirmation_code to request
        $confirmation_code = str_random(30);
        $request['confirmation_code']=$confirmation_code;
           
        // $rules = [
        //     'f1-zip-code' => 'required|min:5',
        //     'email' => 'required|email|min:10|unique:users',
        //     'username' => 'required|min:10|unique:users',            
        //     'website_url'=>'required|min:10',
        //     'company_name'=>'required|min:10',
        //     'primary_phone'=>'required|min:10',
        //     'zipcode'=>'required|min:4'
        // ];

        // $validator = Validator::make($request->all(), $rules);

        // if($validator->fails())
        // {
        //     return Redirect::back()->withInput()->withErrors($validator);
        // }
        
        // passed validation then save user to database	
        $pool=$request->all();
        // if($file)
        // {
        //     $user['logo']=$file->getClientOriginalName();
        // }  
        // else
        // {
        //     $user['logo']='';
        // }

        $val=$this->user->AddNewPoolServiceSubscriber($pool);

        if($val)
        {
            // storeage logo images to local
            // if($file)
            // {
            //     $logo=$file->getClientOriginalName();
            //     $file->storeAs('avatars',$logo);
            // }

            //send email to verify user password_hash
            Mail::send('emails.verify', compact('confirmation_code'), function($message) 
            use ($user)
            {     
                 $message->subject('Your new account');
                 $message->to($user['email'], $user['email']);
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
}
