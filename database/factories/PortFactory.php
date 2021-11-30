<?php

use App\Port;
use Faker\Generator as Faker;

$factory->define(Port::class, function (Faker $faker) {
    return [
        'port_name' => 'Port Name',
        'country_id' => 1,
    ];
});
