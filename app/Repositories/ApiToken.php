<?php

namespace App\Repositories;

//use Illuminate\Http\Request;
use Auth;
use Request;
use Carbon\Carbon;


class ApiToken {

    protected $user;
    public $token;
    protected $key = 'rowboat';

    public function __construct() {
        $this->token = app('App\Models\Tokens');
    }

    public function isValid() {
        $api_token = Request::bearerToken();
        return count($this->getByToken()->first()) ? true :  false;
    }
    
    public function check($data) {
        return Auth::attempt(['email' => $data['email'], 'password' => $data['password']]);
    }
    
    public function getByToken() {
        return $this->token->where('api_token', $api_token)->get();
    }

    public function generateTokenString() {
        return str_random(60);
    }
    
    public function create() {
        $data = Request::all();
        if (!$this->check($data))
            return false;
        $data = [ 
            'api_token' => $this->generateTokenString(),
            'user_id' => Auth::user()->id,
            'client' => $_SERVER['HTTP_USER_AGENT'],
            'expires_on' => Carbon::now()->addDay()
        ];
        return $this->token->create($data);
    }

    public function refreshNewToken() {
        $item = $this->getByToken()->first();
        $item->api_token = $this->generateTokenString();
        return $item->save();
    }

    public function delete($api_token) {
        return $this->getByToken()->delete();
    }

    public function revoke() {
        $item = $this->getByToken()->first();
        $item->revoked = 1;
        $item->save();
    }

    public function isExpired() {
        $now = Carbon::now()->toDateTimeString();
        $expire_on = $this->token->expires_on;
        return ($now < $expire_on);
    }

}
