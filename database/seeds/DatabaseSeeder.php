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
        $this->call(ClearDataSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(OptionSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(StartSeeder::class);
        $this->call(ZipcodeSeeder::class);
    }
}
