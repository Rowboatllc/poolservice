<?php

use Illuminate\Database\Seeder;

class ClearDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->truncate();
        DB::table('options')->truncate();


        DB::table('groups')->truncate();
        DB::table('permissions')->truncate();
        DB::table('users')->truncate();
        DB::table('group_permission')->truncate();
        DB::table('user_group')->truncate();

        DB::table('companies')->truncate();
        DB::table('poolowners')->truncate();
        DB::table('profiles')->truncate();
        DB::table('ratings')->truncate();
        DB::table('selecteds')->truncate();
        DB::table('orders')->truncate();
        DB::table('schedules')->truncate();
        DB::table('notifications')->truncate();
        DB::table('billing_info')->truncate();
        DB::table('technicians')->truncate();
        DB::table('zipcodes')->truncate();
    }
}
