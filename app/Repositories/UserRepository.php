<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    protected $user,$profile,$bill,$pool;
    public function __construct(User $user,Profiles $profile,BillingInfo $bill,PoolSubscriber $pool)
    {
        $this->user = $user;
        $this->profile = $profile;
        $this->bill = $bill;
        $this->pool = $pool;
    }
	public function AddNewPoolServiceSubscriber(array $array)
    {
        // create organization object
		$user=new User();
		$user->email=$array['email'];
        $user->password=bcrypt($array['password']);
		// create new user object 
		$profile = new Profiles();
        $profile->first_name=$array['first_name'];
		$profile->last_name=$array['last_name'];
        $profile->street=$array['street'];
        $profile->city=$array['city'];
        $profile->state=$array['state'];
        $profile->zip=$array['zip'];
        $profile->phone=$array['phone'];
		// create profile Object
		$bill=new BillingInfo();	
		$bill->card_name=$array['card_name'];
		$bill->card_number=$array['card_number'];
		$bill->expiration_date=$array['expiration_date'];
		$bill->ccv=$array['ccv'];
		$bill->billing_address=$array['billing_address'];
		$bill->billing_city=$array['billing_city'];
		$bill->billing_state=$array['billing_state'];
        $bill->zipcode=$array['zipcode'];
        $bill->country='';
        // create organization object
		$pool=new PoolSubscriber();
		$pool->service_type='';
		$pool->cleaning_object='pool';
        $pool->water=$array['water'];
		// using transaction to save data to database
		DB::transaction(function() use ($user, $profile,$bill,$pool)
		{
            // save user
            $user_db=$this->user->save();
            $profile->user_id=$pool->user_id=$bill->user_id=$user_db->id;
            // save user profile			
            $this->profile->save($profile);
			// save pool subscriber
            $this->poll->save($pool);
            // save billing info
            $this->bill->save($bill);
            return true;
        });

		return false;
    }
}
