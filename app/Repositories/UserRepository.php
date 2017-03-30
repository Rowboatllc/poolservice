<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Zipcode;
use App\Models\Profiles;
use App\Models\BillingInfo;
use App\Models\PoolSubscriber;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    protected $user;
	
    public function __construct(User $user)
    {
        $this->user = $user;
    }

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
        if($array['chk_billing_address']=='on')
        {
            $bill->billing_address=$array['street'];
            $bill->billing_city=$array['city'];
            $bill->billing_state=$array['state'];
            $bill->zipcode=$array['zip'];
        }
        else
        {
            $bill->billing_address=$array['billing_address'];
            $bill->billing_city=$array['billing_city'];
            $bill->billing_state=$array['billing_state'];
            $bill->zipcode=$array['zipcode'];
        }		
        
        $bill->country='US';
        $bill->stripe_token=$array['stripeToken'];

        // create organization object
		$pool=new PoolSubscriber();
        $service_type = implode(",", $array['chk_service_type']);  
		$pool->service_type=$service_type;

        $weekly_pool = implode(",", $array['chk_weekly_pool']);
		$pool->cleaning_object=$weekly_pool;
        if(in_array("pool", $array['chk_weekly_pool']))
        {
            $pool->water=$array['rdo_weekly_pool'];
        }
        
        $pool->price=$array['price'];
        $pool->zipcode=$array['zipcode'];;
		// using transaction to save data to database
		DB::transaction(function() use ($user, $profile,$bill,$pool)
		{
            // save user
            $user->status='pending';
            $user_db=$user->save();
            $profile->user_id=$pool->user_id=$bill->user_id=$user->id;
            // save user profile			
            $profile->save();
			// save pool subscriber
            $pool->save();
            // save billing info
            $bill->save();
        });

		return true;
    }

    public function check_email_exist($email)
    {
        return User::where('email', '=',$email)->first();
    }

    public function check_zipcode_exist($zipcode)
    {
        return Zipcode::where('zipcode', '=',$zipcode)->first();
    }

    public function addEmailNotify($email)
    {
        // create organization object
		$user=new User();
        $confirmation_code = str_random(30);
		$user->email=$email;
        $user->password=bcrypt('rowboat');
        $user->confirmation_code=$confirmation_code;

        return $user->save();
    }

    public function confirmPoolAccount(array $arr)
    {
        $user=$this->user->where('confirmation_code', $arr['token'])->first();
        
        return $user->forceFill([
            'password' => bcrypt($arr['password']),
            'status' => 'unclaimed',
        ])->save();
    }
}
