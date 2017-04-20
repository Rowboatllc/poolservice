<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
	protected $table = 'technicians';

    protected $fillable = [
        'user_id', 'company_id', 'avaliable_days'
    ];
}
