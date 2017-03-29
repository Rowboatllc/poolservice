<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BillingInfo extends Model
{
    protected $fillable = ['billing_address','billing_city', 'billing_state', 'country', 'zipcode','stripe_token'];
	protected $table = 'billing_infos';
    protected $primaryKey = 'user_id';
}
