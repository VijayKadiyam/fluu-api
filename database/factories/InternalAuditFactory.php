<?php

use App\InternalAudit;
use Faker\Generator as Faker;

$factory->define(InternalAudit::class, function (Faker $faker) {
    return [
        'site_id' => 2,
        'vessel_id' => 1,
        'start_date' => 'start_date',
        'complition_date' => 'complition_date',
        'port_id' => 1,
        'location'=>"location",
        'country_id' => 1,
        'no_of_issued_deficiencies' => 'no_of_issued_deficiencies',
        'no_of_closed_deficiencies' => 'no_of_closed_deficiencies',
        'is_deficiency_closed' => 0,
        'reportpath' => 'reportpath',
    ];
});
