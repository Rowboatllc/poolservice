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
            'name' => 'pool_owner',
            'description' => 'We are pool owner.',
        ]);

        $group_service_company = factory(App\Models\Group::class)->create([
            'id' => '3',
            'name' => 'service_company',
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

        // set new user admin
        $user_user = factory(App\Models\User::class)->create([
            'name' => 'User',
            'status' => 'active',            
            'email' => 'user@rowboatsoftware.com',            
        ]);

        $group_admin->permissions()->attach($permission_admin_manager->id);
        $group_admin->permissions()->attach($permission_admin_option->id);
        $group_admin->permissions()->attach($permission_admin_option_contact->id);
        $group_admin->permissions()->attach( $permission_admin_page->id);
        $group_admin->permissions()->attach( $permission_admin_administrator->id);

        $group_admin->users()->attach( $user_admin->id);


    }
}