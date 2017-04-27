<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // set group user
        $group_admin = factory(App\Models\Group::class)->create([
            'id' => '1',
            'name' => 'admin',
            'description' => 'We are admin page.',
        ]);

        $group_pool_owner = factory(App\Models\Group::class)->create([
            'id' => '2',
            'name' => 'pool-owner',
            'description' => 'We are pool owner.',
        ]);

        $group_service_company = factory(App\Models\Group::class)->create([
            'id' => '3',
            'name' => 'service-company',
            'description' => 'We are service_company page.',
        ]);

        $group_technician = factory(App\Models\Group::class)->create([
            'id' => '4',
            'name' => 'technician',
            'description' => 'We are technician page.',
        ]);

        // set permission
        $permission_admin_manager = factory(App\Models\Permission::class)->create([
            'name' => 'Admin Manager',
            'alias' => 'admin-manager',            
        ]);

        $permission_admin_option = factory(App\Models\Permission::class)->create([
            'name' => 'Admin Option',
            'alias' => 'admin-option',            
        ]);

        $permission_admin_option_contact = factory(App\Models\Permission::class)->create([
            'name' => 'Admin Option Contact',
            'alias' => 'admin-option-contact',            
        ]);

        $permission_admin_page = factory(App\Models\Permission::class)->create([
            'name' => 'Admin Page',
            'alias' => 'admin-page',            
        ]);

        $permission_admin_administrator = factory(App\Models\Permission::class)->create([
            'name' => 'Admin Administrator',
            'alias' => 'admin-administrator',            
        ]);

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

        factory(App\Models\Order::class)->create([
            'user_id' => $user_pool->id
        ]);
        factory(App\Models\BillingInfo::class)->create([
            'user_id' => $user_pool->id
        ]);
        factory(App\Models\Profile::class)->create([
            'user_id' => $user_pool->id
        ]);

        // set new user user_company
        $user_company = factory(App\Models\User::class)->create([
            'name' => 'Company',
            'status' => 'active',            
            'email' => 'company@rowboatsoftware.com',            
        ]);
        factory(App\Models\BillingInfo::class)->create([
            'user_id' => $user_company->id
        ]);
        factory(App\Models\Profile::class)->create([
            'user_id' => $user_company->id
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
            'user_id' => $user_technician->id
        ]);

         // list user poolowner
        $user_pools = factory(App\Models\User::class, 30)->create();
        foreach($user_pools as $user_pool){
            factory(App\Models\Order::class)->create([
                'user_id' => $user_pool->id
            ]);
            factory(App\Models\BillingInfo::class)->create([
                'user_id' => $user_pool->id
            ]);
            factory(App\Models\Profile::class)->create([
                'user_id' => $user_pool->id
            ]);
        }

        $group_admin->permissions()->attach($permission_admin_manager->id);
        $group_admin->permissions()->attach($permission_admin_option->id);
        $group_admin->permissions()->attach($permission_admin_option_contact->id);
        $group_admin->permissions()->attach( $permission_admin_page->id);
        $group_admin->permissions()->attach( $permission_admin_administrator->id);

        $group_admin->users()->attach( $user_admin->id);
        $group_pool_owner->users()->attach( $user_pool ->id);
        $group_service_company->users()->attach( $user_company->id);
        $group_technician->users()->attach( $user_technician->id);
        



    }
}