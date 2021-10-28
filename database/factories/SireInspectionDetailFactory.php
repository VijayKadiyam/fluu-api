<?php

use App\SireInspectionDetail;
use Faker\Generator as Faker;

$factory->define(SireInspectionDetail::class, function (Faker $faker) {
    return [
        'viq_chapter_id' => 1,
        'serial_no' => 1,
        'details' => "details",
    ];
});
