<?php

use Faker\Generator as Faker;

$factory->define(App\Journal::class, function (Faker $faker) {
    return [
        'title' => title_case($faker->words(rand(1,5), true)),
        'description' => title_case($faker->words(rand(1,10), true)),
        'period' => 604800,
        'active' => true
    ];
});
