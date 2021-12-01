<?php

use App\ChartererInspection;
use Faker\Generator as Faker;

$factory->define(ChartererInspection::class, function (Faker $faker) {
    return [
        'vessel_id' => 1,
        'site_id' => 1,
        'date' => "date1",
        'port_id' => 1,
        'country_id' => 1,
        'no_of_issued_deficiencies' => 1,
        'no_of_closed_deficiencies' => 1,
        'reportpath' => "reportpath",
        'is_deficiency_closed' => 0,
        'additional_comments' => 'Additional Comments',
    ];
});
