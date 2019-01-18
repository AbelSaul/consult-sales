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

$factory->define(App\Seller::class, function (Faker $faker) {
    return [
        "idpersonal" => $faker->unique()->randomNumber($nbDigits = 8),
        "dni" =>  $faker->numberBetween(10000000,99999999),
        "nombre" =>  $faker->name, 
        "direccion" => $faker->address,
        "correo" => $faker->email,
        "correo" => $faker->phoneNumber,
    ];
});
