<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Poolowner extends Model
{
	protected $table = 'poolowners';

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'street', 'city', 'state', 'zipcode', 'phone', 'token', 'card_last_digits', 'pool_status'
    ];
}