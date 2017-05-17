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
use Illuminate\Support\Facades\Storage;
use App\Common\Common;
use DateTime;
use DateInterval;
use DatePeriod;

class UserRepository
{
    protected $user;
    protected $profile;
	protected $company;
    protected $poolowner;

    public function __construct(User $user, Profile $profile,Company $com,Poolowner $poolowner)
    {
        $this->user = $user;
        $this->profile = $profile;
        $this->company=$com;
        $this->poolowner=$poolowner;
        \Stripe\Stripe::setApiKey(env('SECRET_STRIPE'));
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
        $address=Common::geoCode($array['street']);
        $profile->lat=$address[0];
        $profile->lng=$address[1];

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

        if($array['stripeToken']){
            $customer = \Stripe\Customer::create(array(
                "email" => $array['email'],
                "source" => $array['stripeToken'],
            ));	

            $bill->customer_id=$customer->id;
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
		$poolOwner->pool_status='pending'; 
        // add user to user_group
        $userGroup=new UserGroup();
        $group=self::getUserGroupByName('pool-owner');
        $userGroup->group_id=$group->id;
        try {
            // using transaction to save data to database
            DB::transaction(function() use ($user, $profile,$bill,$pool,$poolOwner,$userGroup)
            {
                // save user
                $user->status='pending';
                $user_db=$user->save();
                // set user_id for another object
                $profile->user_id=$pool->poolowner_id=$bill->user_id=$poolOwner->user_id=$userGroup->user_id=$user->id;
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
        $address=Common::geoCode($array['street']);
        $profile->lat=$address[0];
        $profile->lng=$address[1];
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
        
        if($array['stripeToken']){
            $customer = \Stripe\Customer::create(array(
                "email" => $array['email'],
                "source" => $array['stripeToken'],
            ));	

            $bill->customer_id=$customer->id;
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
        $group=self::getUserGroupByName('service-company');
        $userGroup->group_id=$group->id;
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
            WHERE c.status = "active-verified" and JSON_CONTAINS(c.zipcodes, "['.$zipcode.']")');

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

    private function getUserGroup($id) {
        $result = DB::table('users')->select('groups.name')
                ->join('user_group', 'user_group.user_id','=','users.id')
                ->join('groups', 'groups.id','=','user_group.group_id')
                ->where(['users.id' => $id])
                ->first();
        return empty($result->name) ? '' : $result->name;
    }

    private function getUserGroupByName($name) {
        $result = DB::table('groups')->select('groups.id')
                ->where(['groups.name' => $name])
                ->first();
        return $result;
    }

    public function confirmPoolAccount($confirmCode)
    {
        $user=$this->user->where('confirmation_code', $confirmCode)->first();
        if(is_null($user))
        {
            return $user;
        }
        
        $val=self::getUserGroup($user->id);
        switch ($val) {
            case "pool-owner": 
                $this->poolowner->where('user_id', $user->id)
                    ->update([
                    'pool_status' => 'unclaimed'
                ]);
                break;
            case "service-company":                
                $company=$this->company->where('user_id', $user->id)->first(); 
                $company->forceFill([
                    'status' => 'active-unverified',
                ])->save();
                break;
        }

        return $user->forceFill([
            'status' => 'active',
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
            'wq' => '/company-image/'.$arr['wq']->getClientOriginalName(),
            'logo' => '/company-image/'.$arr['logo']->getClientOriginalName(),
            'driver_license' => '/company-image/'.$arr['driven_license']->getClientOriginalName(),
            'cpa' => '/company-image/'.$arr['cpa']->getClientOriginalName()])->save();
            
        $comProfile = self::getCompanyProfile($id);
        return $comProfile;   
    }

    public function getCompanyProfile($id)
    {
        $comProfile = DB::table('companies')
                ->select('companies.id', 'companies.name','companies.website','companies.logo','companies.approved','profiles.address','profiles.fullname','profiles.phone','companies.wq','companies.cpa','companies.driver_license')
                ->join('profiles', 'companies.user_id','=','profiles.user_id')
                ->where(['companies.user_id' => $id])
                ->first();
        
        return $comProfile;
    }

    public function getUserSchedule($id){  
        $dates=Common::getKeyDatesFromRange(new Datetime(),6);
        foreach($dates as $key => $value)
        {      
            $dates[$key]=self::getUserScheduleByDate($id,$value);
        }
        return $dates;
    }

    public function getUserScheduleByDate($id,$date)
    {
        $comProfile = DB::table('schedules')
                ->select('schedules.technican_id as user_id','schedules.date','profiles.city as city','profiles.zipcode as zipcode','profiles.address as address','profiles.lat as lat','profiles.lng as lng','profiles.fullname as fullname')                
                ->join('orders', 'schedules.order_id','=','orders.id')
                ->join('profiles', 'orders.poolowner_id','=','profiles.user_id')
                ->where(['schedules.technican_id' => $id])
                ->whereDate('schedules.date','=', $date)
                ->orderBy('schedules.date')
                ->get();

        return $comProfile;
    }

    public function getUserInfo($id)
    {
        $comProfile = DB::table('users')
                ->select('users.id','users.name','profiles.avatar')
                ->join('profiles', 'profiles.user_id','=','users.id')
                ->where(['users.id' => $id])
                ->first();

        return $comProfile;
    }

    public function getListTechnician($id) {

        $schedules = DB::select('SELECT p.fullname,p.user_id  FROM technicians as t
                                    LEFT JOIN companies c ON c.id = t.company_id
                                    LEFT JOIN profiles p ON p.user_id = t.user_id
                                    WHERE t.company_id in (select id from companies co where co.user_id='.$id.')
                                    ');

        return $schedules;
    }

    public function getListZipcode()
    {
        return DB::table('zipcodes')    
            ->where('zipcodes.zipcode','>', 0)
            ->select('zipcodes.zipcode', 'zipcodes.city')
            ->orderBy('zipcodes.zipcode')
            ->get();
    }
}
