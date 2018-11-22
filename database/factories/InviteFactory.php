<?php

use Faker\Generator as Faker;

$factory->define(App\Invite::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail
    ];
});
