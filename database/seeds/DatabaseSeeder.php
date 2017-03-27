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
        DB::table('zipcode')->insert([
            'address' => str_random(10),
            'zipcode' => rand(2, 5)
        ]);
    }
}
