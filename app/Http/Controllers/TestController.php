<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ApiToken as ApiToken;
use Mail;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $repo;
    public function __construct()
    {
       // $this->middleware('auth');
        //$this->getPageParams();
        $this->repo = app('App\Repositories\OptionRepository');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('test');
    }
    
    public function abc()
    {
        return $this->repo->getOption('rkris');
    }
    
    public function saveAbc(Request $request)
    {
        return $this->repo->getOption('rkris');
    }
    
    private function _getParams($data) {
        
    }
    
     public function createToken()
    {
        $tk = new ApiToken;
        return $tk->create();
    }
    
    public function deleteToken($id) {
        $tk = new ApiToken;
        return $tk->delete($id);
    }
    
    public function revokeToken($id, $revoke=0) {
        $tk = new ApiToken;
        return $tk->revoke($id, $revoke);
    }
    
    public function checkToken() {
        $tk = new ApiToken;
        $valid =  $tk->isValid();
        return response()->json([
                        'valid' => $valid]
            );
    }
    
    public function testmail() {
        Mail::send('testmail', ['user' => 'something here'], function ($m){
            $m->from('lapnguyen1@localhost', 'Your Application');
            $m->to(['lapnguyen1@localhost','lapnguyen@localhost'])->subject('Your Reminder!');
        });
    }
    
    public function confirmByEmail($email, $code) {
        $user = \App\Models\User::where('email', $email)->where('confirmation_code', $code)->get()->first();
        //dd($user);
        $result = true;
        if($user) {
            $user->status = 'active';
            $result = !$user->save();
        }
        return redirect()->route('login')->with('error', $result);
    }
}
