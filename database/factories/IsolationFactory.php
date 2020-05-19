<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Isolation;

$factory->define(Isolation::class, function (Faker $faker) {
    return [
        'user_id' => '1',
        'date' => $faker->unique()->dateTimeThisMonth->format("Y-m-d"),
        'stay_at_home' => $faker->boolean(64),
    ];
});
