<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Models\Zipcode;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group_admin = Group::where('name','admin')->first();
        $group_pool_owner = Group::where('name','pool-owner')->first();
        $group_service_company = Group::where('name','service-company')->first();
        $group_technician = Group::where('name','technician')->first();

        // set new user admin
        $user_admin = factory(App\Models\User::class)->create([
            'name' => 'Admin',
            'status' => 'active',
            'email' => 'admin@rowboatsoftware.com',            
        ]);

        // set new user user_pool
        $user_pool = factory(App\Models\User::class)->create([
            'name' => 'Pool',
            'status' => 'active',            
            'email' => 'pool@rowboatsoftware.com',            
        ]);

        factory(App\Models\BillingInfo::class)->create([
            'user_id' => $user_pool->id
        ]);

        $pool_profile =factory(App\Models\Profile::class)->create([
            'user_id' => $user_pool->id,
            'zipcode' => Zipcode::inRandomOrder()->first()->zipcode
        ]);
        factory(App\Models\Poolowner::class)->create([
            'user_id' => $user_pool->id
        ]);
        factory(App\Models\Order::class)->create([
            'poolowner_id' => $user_pool->id,
            'zipcode' =>[$pool_profile->zipcode]
        ]);
       

        // set new user user_company
        $user_company = factory(App\Models\User::class)->create([
            'name' => 'Company',
            'status' => 'active',            
            'email' => 'company@rowboatsoftware.com'          
        ]);
        factory(App\Models\BillingInfo::class)->create([
            'user_id' => $user_company->id
        ]);
        factory(App\Models\Profile::class)->create([
            'user_id' => $user_company->id,
            'zipcode' => Zipcode::inRandomOrder()->first()->zipcode            
        ]);
        
        // set new user user_technician
        $user_technician = factory(App\Models\User::class)->create([
            'name' => 'Technician',
            'status' => 'active',            
            'email' => 'technician@rowboatsoftware.com',            
        ]);
        factory(App\Models\BillingInfo::class)->create([
            'user_id' => $user_technician->id
        ]);
        factory(App\Models\Profile::class)->create([
            'user_id' => $user_technician->id,
            'zipcode' => Zipcode::inRandomOrder()->first()->zipcode            
        ]);

         // list user poolowner
        $user_pools = factory(App\Models\User::class, 200)->create([
            'status' => 'active',   
        ]);
        
        foreach($user_pools as $user_pool_new){
            factory(App\Models\Poolowner::class)->create([
                'user_id' => $user_pool_new->id
            ]);
            factory(App\Models\Order::class)->create([
                'poolowner_id' => $user_pool_new->id
            ]);
            factory(App\Models\BillingInfo::class)->create([
                'user_id' => $user_pool_new->id
            ]);
            factory(App\Models\Profile::class)->create([
                'user_id' => $user_pool_new->id,
                'zipcode' => Zipcode::inRandomOrder()->first()->zipcode
                
            ]);
        }
       
        $group_admin->users()->attach( $user_admin->id);
        $group_pool_owner->users()->attach( $user_pool ->id);
        $group_service_company->users()->attach( $user_company->id);
        $group_technician->users()->attach( $user_technician->id);
        
    }
}