<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\tw_corporativos;
use Faker\Generator as Faker;

$factory->define(tw_corporativos::class, function (Faker $faker) {
    return [
        'S_NombreCorto' => $faker->userName,
        'S_NombreCompleto' => ($faker->name . ' ' . $faker->lastName),
        'S_DBName' => $faker->colorName,
        'S_DBUsuario' => $faker->unique()->safeEmail,
        'S_DBPassword' => $faker->password,
        'S_SystemUrl' => $faker->url,
        'S_Activo' => true,
        'D_FechaIncorporacion' => now(),
        'tw_usuarios_id' => \App\User::all()->first()->id,
        'created_at' => now()
    ];
});
