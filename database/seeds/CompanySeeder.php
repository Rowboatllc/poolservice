<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
 
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('companies')->delete();
        // DB::table('poolowners')->delete();
         DB::table('orders')->delete();

        $user = DB::table('users')->where('email','user@rowboatsoftware.com')->first();
        $order = factory(App\Models\Order::class)->create([
            'user_id' => $user->id
            ]);
        $order = DB::table('orders')->find($order->id);
        factory(App\Models\Company::class, 10)->make(['zipcodes' => $order->zipcode])->each(function ($com){
            $faker = Faker::create();
            $random = rand(1, 3);
            $com->services = $faker->randomElements(['Weekly cleaning', 'Pool or spa repair', 'Deep cleaning'], $random);
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
            factory(App\Models\Rating::class, $random)->create(['company_id' => $company->id]);
        }
    }
}
