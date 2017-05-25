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
    $random1 = rand(1, 2);
    $services = $faker->randomElements(["weekly_learning", "pool_spa_repair", "deep_cleaning"], $random);
    $cleaning_object = $faker->randomElements(['pool', 'spa'], $random1);
    $water=$faker->randomElements(['salt', 'chlorine'],$random1);
    $zipcodes[] = intval(substr($faker->postcode,0,5));
    return [
        'user_id' => 1,
        'name' => $faker->company,
        'services' => $services,
        'zipcodes' => $zipcodes,
        'cleaning_object' => $cleaning_object,
        'water' => $water,
        'logo' => 'images/company.png',
        'status' => $faker->randomElement(array('pending', 'active-unverified', 'active-verified','suspended', 'inactive')),
        'website' => $faker->url,
        'wq'=>'abc.jpg',
        'driver_license'=>'abc.jpg',
        'cpa'=>'abc.jpg'
    ];
});