<?php

use App\PscInspectionDeficiency;
use Faker\Generator as Faker;

$factory->define(PscInspectionDeficiency::class, function (Faker $faker) {
    return [
        'serial_no' => 1,
        'date_of_closure' => "date_of_closure",
        'evidencepath' => "evidencepath",
        'details' => "details",
    ];
});
