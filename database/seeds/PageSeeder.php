<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('pages')->delete();

        $homePage = factory(App\Models\Page::class)->create([
            'alias' => 'home',
            'title' => 'home',
            'content' => 'Home pages',
            'metadata_keyword' => 'POOLSERVICE,POOL,HOME'
        ]);

        $homePage = factory(App\Models\Page::class)->create([
            'alias' => 'contact',
            'title' => 'contact',
            'content' => 'Contact pages'
        ]);
    }
}