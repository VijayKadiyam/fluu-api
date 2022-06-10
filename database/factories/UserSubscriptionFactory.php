<?php

use App\UserSubscription;
use Faker\Generator as Faker;

$factory->define(UserSubscription::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'subscription_name' => 'subscription_name',
        'date' => 'date',
        'subscription_id' => 1,
    ];
});
