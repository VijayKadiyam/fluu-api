<?php

use App\TerminalInspectionDeficiency;
use Faker\Generator as Faker;

$factory->define(TerminalInspectionDeficiency::class, function (Faker $faker) {
    return [
        'serial_no' => "1",
        'date_of_closure' => "date_of_closure",
        'evidencepath' => "evidencepath",
        'details' => "details",
    ];
});
