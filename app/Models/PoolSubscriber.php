<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PoolSubscriber extends Model
{
    protected $fillable = ['zipcode', 'service_type', 'cleaning_object','water', 'price'];
	protected $table = 'pool_subcribers';

    protected $primaryKey = 'user_id';
}
