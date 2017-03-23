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
            'title' => 'Home',
            'content' => 'Home pages',
            'metadata_keyword' => 'POOLSERVICE,POOL,HOME'
        ]);

        $contactPage = factory(App\Models\Page::class)->create([
            'alias' => 'contact',
            'title' => 'Contact',
            'content' => 'Contact pages'
        ]);
    }
}