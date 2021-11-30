<?php

use App\FscInspectionDeficiency;
use Faker\Generator as Faker;

$factory->define(FscInspectionDeficiency::class, function (Faker $faker) {
    return [
        'serial_no' => 1,
        'date_of_closure' => "date_of_closure",
        'evidencepath' => "evidencepath",
        'details' => "details",
    ];
});
