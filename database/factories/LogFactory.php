<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Log;

$factory->define(Log::class, function (Faker $faker) {
    return [
        'user_id' => '1',
        'lat' => $faker->latitude,
        'lng' => $faker->longitude,
        'date_time' => $faker->dateTimeBetween('2020-04-12', '2020-04-19')->format("Y-m-d H:i:s"),
        'stay_at_home' => $faker->boolean(70)
    ];
});
