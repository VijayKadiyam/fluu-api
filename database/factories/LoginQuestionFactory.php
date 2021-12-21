<?php

use App\LoginQuestion;
use Faker\Generator as Faker;

$factory->define(LoginQuestion::class, function (Faker $faker) {
    return [
        'description' => 'description',
        'is_active' => true,
        'is_mcq' => true,
        'option_1' => 'option_1',
        'option_2' => 'option_2',
        'option_3' => 'option_3',
        'option_4' => 'option_4',
    ];
});
