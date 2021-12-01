<?php

use App\InternalAuditDeficiency;
use Faker\Generator as Faker;

$factory->define(InternalAuditDeficiency::class, function (Faker $faker) {
    return [
        'serial_no' => 1,
        'date_of_closure' => "date_of_closure",
        'evidencepath1' => "evidencepath1",
        'evidencepath2' => "evidencepath2",
        'evidencepath3' => "evidencepath3",
        'evidencepath4' => "evidencepath4",
        'details' => "details",
    ];
});
