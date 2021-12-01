<?php

use App\NearMiss;
use Faker\Generator as Faker;

$factory->define(NearMiss::class, function (Faker $faker) {
    return [
        'site_id' => 2,
        'vessel_id' => 1,
        'number_reported' => 1,
        'location_id' => 1,
        'category_id' => 1,
        'activity_id' => 1,
        'basic_cause_id' => 1,
    ];
});
