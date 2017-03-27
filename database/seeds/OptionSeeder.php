<?php

use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('options')->delete();

        $homePage = factory(App\Models\Page::class)->create([
            'alias' => 'home',
            'title' => 'home',
            'content' => 'Home pages',
            'keywords' => 'POOLSERVICE,POOL,HOME'
        ]);

        $homePage = factory(App\Models\Page::class)->create([
            'alias' => 'contact',
            'title' => 'contact',
            'content' => 'Contact pages'
        ]);
    }
}
