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
$factory->define(App\Models\BillingInfo::class, function (Faker\Generator $faker) {
    return [
        'user_id' => rand(1,100),
        'name_card' => $faker->creditCardType,
        'token' => str_random(10),
        'expiration_date' => $faker->creditCardExpirationDate,
        'card_last_digits' => $fake->creditCardNumber,
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->state,
        'zipcode' => intval(substr($faker->postcode,0,5))
    ];
});