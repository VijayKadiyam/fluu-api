<?php

use App\FscInspection;
use Faker\Generator as Faker;

$factory->define(FscInspection::class, function (Faker $faker) {
    return [
        'site_id' => 2,
        'vessel_id' => 1,
        'date' => 'date',
        'port_id' => 1,
        'country_id' => 1,
        'no_of_issued_deficiencies' => 'no_of_issued_deficiencies',
        'no_of_closed_deficiencies' => 'no_of_closed_deficiencies',
        'is_detained' => 0,
        'is_deficiency_closed' => 0,
        'reportpath' => 'reportpath',
    ];
});
