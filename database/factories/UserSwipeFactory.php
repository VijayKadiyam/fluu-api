<?php

use App\UserSwipe;
use Faker\Generator as Faker;

$factory->define(UserSwipe::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'no_of_swipes' => 'no_of_swipes',
        'date' => 'date',
    ];
});
