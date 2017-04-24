<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Company;
use App\Models\Profile;
use App\Models\Order;
use App\Models\Poolowner;
use App\Models\BillingInfo;
use App\Models\UserGroup;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    protected $user;
    protected $profile;
	protected $company;

    public function __construct(User $user, Profile $profile,Company $com)
    {
        $this->user = $user;
        $this->profile = $profile;
        $this->company=$com;
    }

	public function AddNewPoolOwnerSubscriber(array $array)
    {
        // create organization object
		$user=new User();
		$user->email=$array['email'];
        $user->name=$array['fullname'];
        $user->password=bcrypt($array['password']);
        $user->confirmation_code=$array['confirmation_code'];
		// create new user object 
		$profile = new Profile();
        $profile->first_name=$array['fullname'];
		$profile->last_name=$array['fullname'];
        $profile->fullname=$array['fullname'];
        $profile->address=$array['street'];
        $profile->city=$array['city'];
        $profile->state=$array['state'];
        $profile->zipcode=$array['zip'];
        $profile->phone=$array['phone'];
		// create profile Object
		$bill=new BillingInfo();	
        if($array['chk_billing_address']=='true')
        {
            $bill->address=$array['street'];
            $bill->city=$array['city'];
            $bill->state=$array['state'];
            $bill->zipcode=intval($array['zip']);
        }
        else
        {
            $bill->address=$array['billing_address'];
            $bill->city=$array['billing_city'];
            $bill->state=$array['billing_state'];
            $bill->zipcode=intval($array['zipcode']);
        }		
        
        $bill->name_card=$array['card_name'];
        $bill->expiration_date=$array['expiration_date'];
        $bill->card_last_digits=substr($array['card_number'], -4);
        $bill->token=$array['stripeToken'];

        // create PoolSubscriber object
		$pool=new Order();
		$pool->services=$array['chk_service_type']; 
        $weekly_pool = implode(",", $array['chk_weekly_pool']);
        
		$pool->cleaning_object=$array['chk_weekly_pool'];
        if(in_array("pool", $array['chk_weekly_pool']))
        {            
            $pool->water=$array['rdo_weekly_pool'];
        }
        
        $pool->price=$array['price'];
        $pool->time=date("Y-m-d H:i:s");
        $intArray = array_map(
            function($value) { return (int)$value; },
            $array['zipcode']
        );
        $pool->zipcode=$intArray;

        // add pool_owners info
        $poolOwner=new Poolowner();
		$poolOwner->user_id='pending';  
        // add user to user_group
        $userGroup=new UserGroup();
        $userGroup->group_id=2;
        try {
            // using transaction to save data to database
            DB::transaction(function() use ($user, $profile,$bill,$pool,$poolOwner)
            {
                // save user
                $user->status='pending';
                $user_db=$user->save();
                // set user_id for another object
                $profile->user_id=$pool->user_id=$bill->user_id=$poolOwner->user_id=$userGroup->user_id=$user->id;
                //save pool owner
                $poolOwner->save();
                // save user profile			
                $profile->save();
                // save pool subscriber
                $pool->save();
                // save billing info
                $bill->save();
                // save user to user group
                $userGroup->save();
            });
        } catch (Exception $e) {
            return Redirect::to('/page-not-found');
        }		

		return true;
    }

    public function AddNewPoolServiceSubscriber(array $array)
    {
        // create organization object
		$user=new User();
		$user->email=$array['email'];
        $user->name=$array['fullname'];
        $user->password=bcrypt($array['password']);
        $user->confirmation_code=$array['confirmation_code'];
		// create new user object 
		$profile = new Profile();
        $profile->first_name=$array['fullname'];
		$profile->last_name=$array['fullname'];
        $profile->fullname=$array['fullname'];
        $profile->address=$array['street'];
        $profile->city=$array['city'];
        $profile->state=$array['state'];
        $profile->zipcode=$array['zip'];
        $profile->phone=$array['phone'];
		// create profile Object
		$bill=new BillingInfo();	
        if($array['chk_billing_address']=='true')
        {
            $bill->address=$array['street'];
            $bill->city=$array['city'];
            $bill->state=$array['state'];
            $bill->zipcode=intval($array['zip']);
        }
        else
        {
            $bill->address=$array['billing_address'];
            $bill->city=$array['billing_city'];
            $bill->state=$array['billing_state'];
            $bill->zipcode=intval($array['zipcode']);
        }		
        
        $bill->name_card=$array['card_name'];
        $bill->expiration_date=$array['expiration_date'];
        $bill->card_last_digits=substr($array['card_number'], -4);
        $bill->token=$array['stripeToken'];

        //create company object
        $company=new Company();
        $company->name=$array['company'];
        $company->services=$array['chk_service_type']; 
        $intArray = array_map(
            function($value) { return (int)$value; },
            $array['zipcode']
        );
        
        $company->zipcodes=$intArray;
        $company->logo='';
        $company->status='pending';
        $company->website=$array['website'];
        $company->wq='';
        $company->driver_license='';
        $company->cpa='';
        // add user to user_group
        $userGroup=new UserGroup();
        $userGroup->group_id=3;
        try {
            // using transaction to save data to database
            DB::transaction(function() use ($user, $profile,$bill,$company,$userGroup)
            {
                // save user
                $user->status='pending';
                $user_db=$user->save();
                // set user_id for another object
                $profile->user_id=$bill->user_id=$company->user_id=$userGroup->user_id=$user->id;
                // save user profile			
                $profile->save();
                // save billing info
                $bill->save();
                // save company
                $company->save();
                // save user to user group
                $userGroup->save();
            });
        } catch (Exception $e) {
            return Redirect::to('/page-not-found');
        }	

		return true;
    }

    public function check_email_exist($email)
    {
        return User::where('email', '=',$email)->first();
    }

    public function check_zipcode_exist($zipcode)
    {
        if(empty($zipcode)) return [];

        $results = DB::select('SELECT c.id FROM `companies` as c 
            WHERE c.status = "active" and JSON_CONTAINS(c.zipcodes, "['.$zipcode.']")');

        return $results;         
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

    public function confirmPoolAccount($confirmCode)
    {
        $user=$this->user->where('confirmation_code', $confirmCode)->first();
        if(is_null($user))
        {
            return $user;
        }
        
        return $user->forceFill([
            'status' => 'unclaimed',
        ])->save();
    }

    public function checkLogin(array $arr)
    {
        $user = DB::table('users')->select('user_group.group_id')
                ->join('user_group', 'user_group.user_id','=','users.id')
                ->where(['users.email' => $arr['email']])
                ->whereNotIn('status', ['pending'])
                ->first();
        return $user;
    }

    public function getProfileByUserId($user_id){
        return $this->profile->find($user_id);
    }

    public function getUserByUserId($user_id){
        return $this->user->find($user_id);
    }

    public function confirmTechnicianAccount(array $array)
    {
        $user =  $this->user->where([
            ['confirmation_code', $array['confirmCode']],
            ['email', $array['email']],
            ['status', 'pending'],            
            ])->first();
        if(isset($user)){
            $user->password = bcrypt($array['password']);
            $user->status = 'active';
            return $user->save();
        }else{
            return false;
        }
    }

    public function getUserByTocken($confirmCode){
        return $this->user->where([['confirmation_code', $confirmCode],['status', 'pending']])->first();
    }

    public function updateCompanyProfile(array $arr,$id)
    {
        $com=$this->company->where('user_id', $id)->first();
        if(is_null($com))
        {
            return $com;
        }
        
        $com->forceFill([
            'wq' => $arr['wq']->getClientOriginalName(),
            'logo' => $arr['logo']->getClientOriginalName(),
            'driver_license' => $arr['driven_license']->getClientOriginalName(),
            'cpa' => $arr['cpa']->getClientOriginalName()])->save();
            
        return $com;
    }
}
