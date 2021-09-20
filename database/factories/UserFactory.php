<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name'     =>  $faker->name,
        'lastname' =>  $faker->lastname,
        'dni'      =>  $faker->unique()->randomNumber,
        'address'  =>  $faker->address,
        'phone'    =>  $faker->phoneNumber,
        'gender'   =>  $faker->randomElement(['M', 'F']),
        'birthdate'=>  $faker->date($format = 'Y-m-d', $max = 'now'),
        'username' =>  $faker->userName,
        'email'    =>  $faker->unique()->safeEmail,
        'password' =>  bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
