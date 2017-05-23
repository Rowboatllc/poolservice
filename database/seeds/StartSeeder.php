<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
 
use Faker\Factory as Faker;
use App\Models\Zipcode;

class StartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $user = DB::table('users')->where('email','pool@rowboatsoftware.com')->first();
        $order = DB::table('orders')->where('poolowner_id',$user->id)->first();

        $user_company = DB::table('users')->where('email','company@rowboatsoftware.com')->first();
        factory(App\Models\Company::class,1)->make(['zipcodes' => $order->zipcode,'user_id'=>$user_company->id])->each(function ($com){
            $faker = Faker::create();
            $random = rand(1, 3);
            $com->services = ["weekly_learning", "pool_spa_repair", "deep_cleaning"];

            $random_zipcode = rand(5,20);
            $zipcodes = Zipcode::get()->pluck('zipcode')->toArray();
            // $zipcodes [] = json_decode($com->zipcodes);
            $com->zipcodes = $zipcodes;

            $com->status = 'active-verified';
            $com->save();
            
            return $com;
        });
        
        $company = DB::table('companies')->first();

        factory(App\Models\Company::class, 10)->make(['zipcodes' => $order->zipcode])->each(function ($com_new){
            $faker = Faker::create();
            $random = rand(1, 3);
            $com_new->services = $faker->randomElements(["weekly_learning", "pool_spa_repair", "deep_cleaning"], $random);
            
             $random_zipcode = rand(5,20);
            $zipcodes = Zipcode::inRandomOrder()->take($random_zipcode)->pluck('zipcode')->toArray();
            $zipcodes [] = json_decode($com_new->zipcodes)[0];
            $com_new->zipcodes = $zipcodes;

            $ran = array('pending', 'active-unverified', 'active-verified','suspended', 'inactive');
            $com_new->status = $ran[array_rand($ran, 1)];
            $com_new->save();
        });
        
        // Rating
        $companys = DB::table('companies')->get();
        foreach($companys as $company_new){
            $random = rand(1, 5);
            factory(App\Models\Rating::class, $random)->create([
                'company_id' => $company_new->id
                ]);
        }

        
        $user_technician = DB::table('users')->where('email','technician@rowboatsoftware.com')->first();
        DB::table('technicians')->insert([
            ['user_id' => $user_technician->id, 'company_id' => $company->id, 'is_owner'=>0, 'avaliable_days' => new \DateTime()]
        ]);

        $orders = DB::table('orders')->where('poolowner_id','<>', $user->id)->get();
        foreach($orders as $order_new){
            $status_selected = 'active';
            $random = rand(1,10); 
            if($random<=8){
                $status_selected = 'assigned';
            }
            if($status_selected =='assigned'){
                $date_selected = $faker->randomElements([2,3,4,5,6], 1);

                $selected = factory(App\Models\Selected::class)->create([
                    'order_id' => $order_new->id,
                    'company_id' => $company->id,
                    'status' => $status_selected,
                    'dayofweek' => $date_selected[0],
                    'technician_id' => $user_technician->id
                ]);
                
                $schedule = factory(App\Models\Schedule::class)->create([
                    'selected_id' => $selected->id, 
                    'technician_id' => $user_technician->id, 
                ]);
            }else{

                factory(App\Models\Selected::class)->create([
                    'order_id' => $order_new->id, 
                    'company_id' => $company->id, 
                    'status' => $status_selected
                ]);
            }
            
        }

        $date = new \DateTime();
        $dayofweek = $date->format('N');
        $dayofweek ++;
        $selected = factory(App\Models\Selected::class)->create([
            'order_id' => $order->id,
            'company_id' => $company->id,
            'status' => 'active',
            'dayofweek' => $dayofweek,
            'technician_id' => $user_technician->id
        ]);

        for($i=0;$i<100;$i++){
            $status = 'opening';
            $ran = array ('opening', 'checkin', 'unable', 'billing_success', 'billing_error');
            if($i==0){
                $ran = array ('opening');
            }
            if($i>1){
                $ran = array ('unable', 'billing_success', 'billing_error');
            }
            $status = $ran[array_rand($ran, 1)];

            factory(App\Models\Schedule::class)->create([
                'selected_id' => $selected->id, 
                'technician_id' => $user_technician->id, 
                'date' => $date,
                'status' => $status
            ]);

            $date->modify('-7 day');
        }
    }
}
