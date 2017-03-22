<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BillingInfo extends Model
{
    protected $fillable = ['card_name', 'billing_address','billing_city', 'billing_state', 'country', 'zipcode','card_number','expiration_date','ccv'];
	protected $table = 'billing_infos';
    protected $primaryKey = 'user_id';
}
