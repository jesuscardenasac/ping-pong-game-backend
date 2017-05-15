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
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Solicitud::class, function (Faker\Generator $faker) {
    return [
        'id_user_emisor' => $faker->numberBetween($min = 1, $max = 10),
        'id_user_receptor' => $faker->numberBetween($min = 1, $max = 10),
        'estado' => 'enviada',
    ];
});

$factory->define(App\Models\Juego::class, function (Faker\Generator $faker) {
    return [
        'id_solicitud' => $faker->numberBetween($min = 1, $max = 10),
        'estado' => 'iniciado',
    ];
});

$factory->define(App\Models\Partida::class, function (Faker\Generator $faker) {
    return [
        'id_juego' => $faker->numberBetween($min = 1, $max = 10),
        'puntos_emisor' => $faker->numberBetween($min = 1, $max = 10),
        'puntos_receptor' => $faker->numberBetween($min = 1, $max = 10),
        'estado' => 'iniciada',
    ];
});
