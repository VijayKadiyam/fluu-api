<?php

use App\UserNotification;
use Faker\Generator as Faker;

$factory->define(UserNotification::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'notification_id' =>  1,
        'is_active' =>   true,
    ];
});
