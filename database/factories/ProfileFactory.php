<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Profile;
use App\User;

$factory->define(Profile::class, function (Faker $faker) {

    $prefecture = ['Hokkaido', 'Tokyo', 'Aichi', 'Okayama', 'Fukuoka'];

    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        //'country_id',
        'prefecture' => $faker->randomElement($prefecture),
        'postal_code' => $faker->randomNumber(7),
        'origin_lat' => $faker->latitude,
        'origin_lng' => $faker->longitude,
        'cohabitant' => $faker->numberBetween(0, 5),
        'contact_weekday' => $faker->numberBetween(0, 50),
        'contact_weekend' => $faker->numberBetween(0, 50),
    ];
});
