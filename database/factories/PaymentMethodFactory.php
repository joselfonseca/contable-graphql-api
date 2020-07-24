<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\PaymentMethod::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class),
        'name' => $faker->name,
    ];
});
