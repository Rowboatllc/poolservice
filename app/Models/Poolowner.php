<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Poolowner extends Model
{
	protected $table = 'poolowners';

    protected $fillable = [
        'user_id','pool_status'
    ];
}