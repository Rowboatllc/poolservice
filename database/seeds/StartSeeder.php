<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
 
use Faker\Factory as Faker;

class StartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->where('email','pool@rowboatsoftware.com')->first();
        
        $order = factory(App\Models\Order::class)->create([
            'user_id' => $user->id
            ]);
        $order = DB::table('orders')->find($order->id);

        $user_company = DB::table('users')->where('email','company@rowboatsoftware.com')->first();

        factory(App\Models\Company::class, 10)->make(['zipcodes' => $order->zipcode,'user_id'=>$user_company->id])->each(function ($com){
            $faker = Faker::create();
            $random = rand(1, 3);
            $com->services = $faker->randomElements(["weekly_learning", "pool_spa_repair", "deep_cleaning"], $random);
            $i=1; $zipcodes = json_decode($com->zipcodes);
            while($i<=$random){
                $zipcodes[] = intval(substr($faker->postcode,0,5));
                $i++;
            }
            $com->zipcodes = $zipcodes;
            $com->save();
        });

        $companys = DB::table('companies')->get();
        foreach($companys as $company){
            $random = rand(1, 5);
            factory(App\Models\Rating::class, $random)->create([
                'company_id' => $company->id
                ]);
        }

        $company = DB::table('companies')->first();
        $user_technician = DB::table('users')->where('email','technician@rowboatsoftware.com')->first();
        DB::table('technicians')->insert([
            ['user_id' => $user_technician->id, 'company_id' => $company->id, 'is_owner'=>0, 'avaliable_days' => new \DateTime()]
        ]);

        for($i=0;$i<20;$i++){

            $order_new = factory(App\Models\Order::class)->create([
            'user_id' => $user->id
            ]);

            $schedule = factory(App\Models\Schedule::class)->create([
                'technican_id' => $user_technician->id, 
                'order_id' => $order_new->id, 
                'company_id' => $company->id,
            ]);
        }
        
    }
}
