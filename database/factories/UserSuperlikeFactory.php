<?php

use App\UserSuperlike;
use Faker\Generator as Faker;

$factory->define(UserSuperlike::class, function (Faker $faker) {
    return [
        'user_id'=>1,
        'liked_user_id'=>1,
    ];
});
