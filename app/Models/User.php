<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Validation\ValidatesRequests;

class User extends Model implements Authenticatable, CanResetPasswordContract 
{
    use Notifiable,
        AuthenticableTrait,
        CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname', 'email', 'password', 'confirmation_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function tokens() {
        return $this->hasMany('App\Models\Tokens');
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile','user_id');
    }
}
