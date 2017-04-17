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
$factory->define(App\Models\Company::class, function (Faker\Generator $faker) {
    $random = rand(1, 3);
    $services = $faker->randomElements(["weekly_learning", "pool_spa_repair", "deep_cleaning"], $random);
    $zipcodes[] = intval(substr($faker->postcode,0,5));
    return [
        'user_id' => 1,
        'name' => $faker->company,
        'services' => $services,
        'zipcodes' => $zipcodes,
        'logo' => $faker->imageUrl($width = 640, $height = 480),
        'status' => $faker->randomElement(array ('active', 'inactive')),
        'website' => $faker->url
    ];
});