<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Income::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class),
        'category_id' => factory(App\Category::class),
        'date' => $faker->dateTime(),
        'amount' => $faker->randomFloat(),
        'description' => $faker->text,
    ];
});
