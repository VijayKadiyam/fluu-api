<?php

use App\Vessel;
use Faker\Generator as Faker;

$factory->define(Vessel::class, function (Faker $faker) {
    return [
        'serial_no' => "serial_no",
        'name' => "name",
        'imo_no' => 1,
        'vessel_type_id' => 1,
        'built_date' => "built_date",
        'built_place' => "built_place",
        'dwt' => "dwt",
        'management_in_date' => "management_in_date",
        'management_out_date' => "management_out_date",
        'remarks' => "remarks",
        'no_of_deck_officers' => 1,
        'no_of_engine_officers' => 1,
        'no_of_deck_rating' => 1,
        'no_of_engine_rating' => 1,
        'no_of_galley_rating' => 1,
        'officer_nationalities' => 1,
        'rating_nationalities' => 1,
    ];
});
