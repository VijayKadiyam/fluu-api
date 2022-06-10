<?php

use App\Subscription;
use Faker\Generator as Faker;

$factory->define(Subscription::class, function (Faker $faker) {
    return [
        "subscription_name" => "subscription_name"
    ];
});
