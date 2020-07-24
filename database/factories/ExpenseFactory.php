<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Expense::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class),
        'category_id' => factory(App\Category::class),
        'payment_method_id' => factory(App\PaymentMethod::class),
        'date' => $faker->dateTime(),
        'amount' => $faker->randomFloat(),
        'description' => $faker->text,
    ];
});
