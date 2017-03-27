<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Page::class, function (Faker\Generator $faker) {

    return [
        'alias' => $faker->unique()->jobTitle,
        'title' => $faker->word,
        'content' => $faker->sentence,
        'keywords' => 'POOLSERVICE,POOL',
        'description' => 'FIND AN EXPERIENCED TECHNICIAN FOR ALL OF YOUR POOL SERVICE NEEDS',
        
    ];
});