<?php

use App\NearMiss;
use Faker\Generator as Faker;

$factory->define(NearMiss::class, function (Faker $faker) {
    return [
        'number_reported' => 1,
        'location_id' => 1,
        'category_id' => 1,
        'activity_id' => 1,
        'basic_cause_id' => 1,
    ];
});
