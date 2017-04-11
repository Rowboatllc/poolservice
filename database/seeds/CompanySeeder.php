<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
 
use Faker\Factory as Faker;
// use DB;
class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('companys')->delete();
        // DB::table('poolowners')->delete();
         DB::table('orders')->delete();

        $user = DB::table('users')->where('email','user@rowboatsoftware.com')->first();
        $order = factory(App\Models\Order::class)->create([
            'user_id' => $user->id
            ]);
        
        factory(App\Models\Company::class, 10)->make([''])->each(function ($com){
            $faker = Faker::create();
            $random = rand(1, 3);
            $com->services = $faker->randomElements(['Weekly cleaning', 'Pool or spa repair', 'Deep cleaning'], $random);
            $i=0; $zipcodes = [];
            while($i<=$random){
                $zipcodes[] = intval(substr($faker->postcode,0,5));
                $i++;
            }
            $com->zipcodes = $zipcodes;
            $com->save();
        });

        // $owner = factory(App\Models\Poolowner::class)->create();

        // $q = "json_contains(services, \"".json_encode($owner->services)."\")";
        // $abc = DB::table('companys')->whereRaw($q)->get();
        // dd($abc);
        //SELECT * FROM `companys` as c LEFT JOIN owners o ON JSON_CONTAINS(c.services, o.services) WHERE o.id = 8

        
    }
}
