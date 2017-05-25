<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

    protected $table = 'companies';
    protected $fillable = [
        'user_id', 'name', 'services', 'zipcodes','cleaning_object','water', 'logo', 'status', 'website', 'wq', 'cpa', 'driver_license'
    ];
    protected $casts = [
        'services' => 'array',
        'zipcodes' => 'array',
        'cleaning_object'=>'array',
        'water'=>'array'
    ];

    public function ratings() {
        return $this->hasMany('App\Models\Rating', 'company_id');
    }

}
