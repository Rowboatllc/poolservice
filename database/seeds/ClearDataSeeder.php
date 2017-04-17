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
        DB::table('companies')->delete();
        DB::table('poolowners')->delete();
        DB::table('options')->delete();
        DB::table('pages')->delete();
        DB::table('groups')->delete();
        DB::table('permissions')->delete();
        DB::table('users')->delete();
    }
}
