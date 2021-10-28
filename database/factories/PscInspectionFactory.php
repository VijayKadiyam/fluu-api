<?php

use App\PscInspection;
use Faker\Generator as Faker;

$factory->define(PscInspection::class, function (Faker $faker) {
    return [
        'vessel_id' => 1,
        'date' => "date",
        'port_id' => 1,
        'country_id' => 1,
        'deficiency_id' => 1,
        'is_detained' => 0,
        'reportpath' => "reportpath",
        'is_deficiency_closed' => 0,
        'date_of_closure' => "date_of_closure",
        'evidencepath' => "evidencepath",
    ];
});
