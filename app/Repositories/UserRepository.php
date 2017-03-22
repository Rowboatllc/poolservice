<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Profiles;
use App\Models\BillingInfo;
use App\Models\PoolSubscriber;
use Illuminate\Support\Facades\DB;

class UserRepository
{
	public function AddNewPoolServiceSubscriber(array $array)
    {
        // create organization object
		$user=new User();
		$user->email=$array['email'];
        $user->password=bcrypt($array['password']);
        $user->confirmation_code=$array['confirmation_code'];
		// create new user object 
		$profile = new Profiles();
        $profile->first_name=$array['fullname'];
		$profile->last_name=$array['fullname'];
        $profile->full_name=$array['fullname'];
        $profile->street=$array['street'];
        $profile->city=$array['city'];
        $profile->state=$array['state'];
        $profile->zip=$array['zip'];
        $profile->phone=$array['phone'];
		// create profile Object
		$bill=new BillingInfo();	
		$bill->card_name=$array['card_name'];
		$bill->card_number=$array['card_number'];
		$bill->expiration_date=date("Y-m-d");//$array['expiration_date'];
		$bill->ccv=$array['ccv'];
		$bill->billing_address=$array['billing_address'];
		$bill->billing_city=$array['billing_city'];
		$bill->billing_state=$array['billing_state'];
        $bill->zipcode=$array['zipcode'];
        $bill->country='';
        // create organization object
		$pool=new PoolSubscriber();
		$pool->service_type='';//$array['service_type'];
		$pool->cleaning_object='pool';//$array['cleaning_object'];
        $pool->water='salt';//$array['water'];
        $pool->price=0;
        $pool->zipcode=123456;
		// using transaction to save data to database
		DB::transaction(function() use ($user, $profile,$bill,$pool)
		{
            // save user
            $user_db=$user->save();
            $profile->user_id=$pool->user_id=$bill->user_id=$user->id;
            // save user profile			
            $profile->save();
			// save pool subscriber
            $pool->save();
            // save billing info
            $bill->save();
            // return true;
        });
        // dd('saved OK!!!!');
		return false;
    }
}
