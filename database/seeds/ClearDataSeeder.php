<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
 
use Faker\Factory as Faker;

class ClearDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->delete();
        DB::table('options')->delete();


        DB::table('groups')->delete();
        DB::table('permissions')->delete();
        DB::table('users')->delete();
        DB::table('group_permission')->delete();
        DB::table('user_group')->delete();

        DB::table('companies')->delete();
        DB::table('poolowners')->delete();
        DB::table('profiles')->delete();
        DB::table('ratings')->delete();
        DB::table('selecteds')->delete();
        DB::table('orders')->delete();
        DB::table('schedules')->delete();
        DB::table('notifications')->delete();
        DB::table('billing_info')->delete();
    }
}
