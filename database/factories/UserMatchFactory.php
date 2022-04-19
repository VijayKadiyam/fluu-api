<?php

use App\UserMatch;
use Faker\Generator as Faker;

$factory->define(UserMatch::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'matched_user_id' => 1,
        'date' => 'date',
    ];
});
