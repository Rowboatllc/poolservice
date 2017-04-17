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
$factory->define(App\Models\Poolowner::class, function (Faker\Generator $faker) {
    $random = rand(1, 3);
    $services = $faker->randomElements(["weekly_learning", "pool_spa_repair", "deep_cleaning"], $random);
    return [
        'name' => $faker->company,
        'services' => $services,
        'zipcode' => $faker->postcode
    ];
});