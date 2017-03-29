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

        $group_admin = factory(App\Models\Group::class)->create([
            'name' => 'admin',
            'description' => 'We are admin page.',
        ]);

        $group_pool_owner = factory(App\Models\Group::class)->create([
            'name' => 'pool_owner',
            'description' => 'We are pool owner.',
        ]);

        $permission_view_admin = factory(App\Models\Permission::class)->create([
            'name' => 'View Admin',
            'alias' => 'view.admin',            
        ]);

        $permission_edit_admin = factory(App\Models\Permission::class)->create([
            'name' => 'Edit Admin',
            'alias' => 'edit.admin',            
        ]);

        $permission_delete_admin = factory(App\Models\Permission::class)->create([
            'name' => 'Delete Admin',
            'alias' => 'delete.admin',            
        ]);

        $permission_view_home = factory(App\Models\Permission::class)->create([
            'name' => 'View Home',
            'alias' => 'view.home',            
        ]);

        $user_admin = factory(App\Models\User::class)->create([
            'name' => 'Admin',
            'email' => 'an@rowboatsoftware.com',            
        ]);

        $group_admin->permissions()->attach($permission_view_admin->id);
        $group_admin->permissions()->attach($permission_edit_admin->id);
        $group_admin->permissions()->attach($permission_delete_admin->id);
        
        $group_pool_owner->permissions()->attach( $permission_view_home->id);

        $group_admin->users()->attach( $user_admin->id);

        // $find = App\Models\Group::find($group_admin->id);
        // dd($find->permissions->contains($permission_view_admin->id));
        // dd($find->permissions()->detach($permission_view_admin->id));
    }
}
