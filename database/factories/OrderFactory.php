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
$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {
    $random = rand(1, 3);
    $services = $faker->randomElements(['Weekly cleaning', 'Pool or spa repair', 'Deep cleaning'], $random);
    $zipcode = intval(substr($faker->postcode,0,5));
    return [
        'user_id' => $faker->numberBetween(1,20),
        'services' => $services,
        'zipcode' => $zipcode,
        'time' => $faker->dateTime,
        'cleaning_object' => $faker->randomElement(array ('pool', 'spa')),
        'water' => $faker->randomElement(array ('salt', 'chlorine')),
        'price' => $faker->numberBetween(25,50),
    ];
});