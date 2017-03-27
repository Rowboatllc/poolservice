<?php

use Illuminate\Database\Seeder;

class ZipcodeSeeder extends Seeder
{
    public function run()
    {
        //
        DB::table('zipcode')->delete();
    }
}