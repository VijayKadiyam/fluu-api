<?php

use App\UserLike;
use Faker\Generator as Faker;

$factory->define(UserLike::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'liked_user_id' => 1,
        'action' => "action",
    ];
});
