<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PageSeeder::class);
        $this->call(OptionSeeder::class);
        $this->call(ZipcodeSeeder::class);
        $this->call(PermissionSeeder::class);
    }
}
