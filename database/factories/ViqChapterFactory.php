<?php

use App\ViqChapter;
use Faker\Generator as Faker;

$factory->define(ViqChapter::class, function (Faker $faker) {
    return [
        'serial_no' => 1,
        'chapter_name'=> 'Chapter Name'
    ];
});
