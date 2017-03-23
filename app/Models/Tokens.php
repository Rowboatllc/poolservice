<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tokens extends Model {

    protected $table = 'tokens';
    protected $fillable = ['api_token', 'client', 'user_id', 'expires_on'];

    public function scopeValid() {
        return !Carbon\Carbon::createFromTimeStamp(strtotime($this->expires_on))->isPast();
    }

    public function user() {
        return $this->belongsTo('User', 'user_id');
    }

}