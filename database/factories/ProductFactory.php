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

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        "idproducto" => $faker->unique()->randomNumber($nbDigits = 8),
        "idlocal" => $faker->unique()->randomNumber,
        "codigo" => $faker->ean8,
        "codigo2" => $faker->ean8,
        "descripcion" => $faker->jobTitle,
        "precio" => $faker->randomFloat(),
        "precio1" => $faker->randomFloat(),
        "precio2" => $faker->randomFloat()
    ];
});
