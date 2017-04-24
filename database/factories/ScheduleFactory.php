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
$factory->define(App\Models\Schedule::class, function (Faker\Generator $faker) {
    return [
        'technican_id' => 1, 
        'order_id' => 1, 
        'company_id' => 1, 
        'date' => $faker->dateTime, 
        'img_before' => $faker->imageUrl($width = 640, $height = 480),
        'img_after' => $faker->imageUrl($width = 640, $height = 480),
        'status' => 'opening', 
        'cost' => $faker->numberBetween(25,50),
        'cleaning_steps' => $faker->dateTime, 
        'comment' => $faker->dateTime
    ];
});