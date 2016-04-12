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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    $faker = Faker\Factory::create('it_IT');
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'password' => bcrypt('secret'),
        'remember_token' => str_random(10),
        'role' => $faker->randomElement(['user','user','user','user','editor']),
        'active' => true,
    ];
});
