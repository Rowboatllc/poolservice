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
        'date' => $faker->dateTimeBetween($startDate = '-6 days', $endDate = '+6 days'), 
        'img_before' => $faker->imageUrl($width = 640, $height = 480),
        'img_after' => $faker->imageUrl($width = 640, $height = 480),
        'status' => $faker->randomElement(array ('opening', 'complete')),
        'cleaning_steps' => [1,2,3], 
        'comment' => $faker->sentence
    ];
});