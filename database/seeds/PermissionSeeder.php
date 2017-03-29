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
        DB::table('groups')->delete();
        DB::table('permissions')->delete();
        DB::table('users')->delete();

        // set group user
        $group_admin = factory(App\Models\Group::class)->create([
            'name' => 'admin',
            'description' => 'We are admin page.',
        ]);

        $group_pool_owner = factory(App\Models\Group::class)->create([
            'name' => 'pool_owner',
            'description' => 'We are pool owner.',
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

        // set new user admin
        $user_admin = factory(App\Models\User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@rowboatsoftware.com',            
        ]);

        $group_admin->permissions()->attach($permission_admin_manager->id);
        $group_admin->permissions()->attach($permission_admin_option->id);
        $group_admin->permissions()->attach($permission_admin_option_contact->id);
        $group_admin->permissions()->attach( $permission_admin_page->id);

        $group_admin->users()->attach( $user_admin->id);


    }
}