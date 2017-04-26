<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model {

    protected $table = 'technicians';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id', 'company_id', 'is_owner', 'avaliable_days'
    ];

}
