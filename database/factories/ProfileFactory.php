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
$factory->define(App\Models\Profile::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'fullname' => $faker->name,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->state,
        'zipcode' => intval(substr($faker->postcode,0,5)),
        'phone' => $faker->phoneNumber,
        'avatar' => $faker->imageUrl,
        'lat' => $faker->latitude($min = 33.298891, $max = 33.784414),
        'lng' => $faker->longitude($min = -112.191725, $max = -111.949924)
    ];
});