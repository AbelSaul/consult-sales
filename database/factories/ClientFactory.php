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

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        "idcliente" => $faker->unique()->randomNumber($nbDigits = 8),
        "ruc" =>  $faker->numberBetween(10000000000,99999999999),
        "cliente" => $faker->name,
        "direccion" => $faker->address,
        "celular" => $faker->phoneNumber ,
        "dni" =>  $faker->numberBetween(10000000,99999999),
        "lista_prec" => 0,
        "credito" => 0.00,
        "fecha" => date("Y-m-d"),
    ];
});
