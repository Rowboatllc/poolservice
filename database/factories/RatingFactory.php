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
$factory->define(App\Models\Rating::class, function (Faker\Generator $faker) {
    return [
        'user_id' => rand(1, 100),
        'company_id' => rand(1, 100),
        'point' => rand(1, 5)
    ];
});