<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
            'name' => 'admin',
            'description' => 'We are admin page.',
        ]);

        $group_pool_owner = factory(App\Models\Group::class)->create([
            'name' => 'pool-owner',
            'description' => 'We are pool owner.',
        ]);

        $group_service_company = factory(App\Models\Group::class)->create([
            'name' => 'service-company',
            'description' => 'We are service_company page.',
        ]);

        $group_technician = factory(App\Models\Group::class)->create([
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

        $group_admin->permissions()->attach($permission_admin_manager->id);
        $group_admin->permissions()->attach($permission_admin_option->id);
        $group_admin->permissions()->attach($permission_admin_option_contact->id);
        $group_admin->permissions()->attach( $permission_admin_page->id);
        $group_admin->permissions()->attach( $permission_admin_administrator->id);
        
        $arr = [
            'poolowner' => [
                'pool-owner',
                'update-billing-info',
                'select-company',
                'select-new-company',
                'rating-company',
                'get-point-rating-company',

                'dashboard-poolowner-save-email',
                'dashboard-poolowner-save-password',
                'dashboard-poolowner-save-profile',
                'dashboard-poolowner-save-poolinfo',
                'get-all-services-of-poolowner'
            ],
            'company' => [
                'service-company',
                'update-billing-info',
                'dashboard-company-change-services-offer',

                'dashboard-company-list-technician',
                'dashboard-company-save-technician',
                'dashboard-company-remove-technician',
                
                'dashboard-company-list-customer',
                'dashboard-company-accept-deny-offer',
                'dashboard-company-getlist-offer',

                'ajax-upload-file',
                'ajax-upload-image',
                'load-pool-owner',
                'upload-company-profile',
                'ajax-upload-an-image'
            ],
            'techician'=>[
                'technician',
                'technician-enroute',
                'technician-complete-steps',
                'technician-unable-steps'
            ]
        ];

        foreach($arr as $group => $ps){
            foreach($ps as $k => $p){
                $pms = DB::table('permissions')->where('alias',$p)->first();
                if(!isset($pms)){
                    $pms = factory(App\Models\Permission::class)->create([
                        'name' => $p,
                        'alias' => $p
                    ]);
                }
                switch($group) {
                    case 'poolowner':
                        $group_pool_owner->permissions()->attach($pms);
                        break;
                    case 'company':
                        $group_service_company->permissions()->attach($pms);
                        break;
                    case 'techician':
                        $group_technician->permissions()->attach($pms);
                        break;
                    case '':
                        $group_admin->permissions()->attach($pms);
                        break;
                }
            }
        }
    }
}