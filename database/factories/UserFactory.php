<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'email_verified_at' => $faker->dateTime(),
        'password' => bcrypt($faker->password),
        'remember_token' => Str::random(10),
        'provider' => $faker->word,
        'provider_id' => $faker->word,
        'avatar' => $faker->word,
    ];
});
