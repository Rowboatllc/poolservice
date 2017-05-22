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
$factory->define(App\Models\Selected::class, function (Faker\Generator $faker) {

    return [
        'order_id' => 1,
        'company_id' => 1,
        'status' => 'active',
        'dayofweek' => 2,
        'technician_id' => 4
    ];
});