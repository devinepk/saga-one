<?php

use Faker\Generator as Faker;

$factory->define(App\Journal::class, function (Faker $faker) {
    return [
        'title' => title_case($faker->words(4, true))
    ];
});
