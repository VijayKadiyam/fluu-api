<?php

use App\SireInspection;
use Faker\Generator as Faker;

$factory->define(SireInspection::class, function (Faker $faker) {
    return [
        'vessel_id' => 1,
        'inspection_type' => "inspection_type",
        'inspection_type_detail' => "inspection_type_detail",
        'oil_major_id' => 1,
        'date_of_inspection' => "date_of_inspection",
        'inspector_id' => 1,
        'total_observations' => "total_observations",
        'attachment' => "attachment",
        'port_id' => 1,
        'country_id' => 1,
        'address' => "address",
    ];
});
