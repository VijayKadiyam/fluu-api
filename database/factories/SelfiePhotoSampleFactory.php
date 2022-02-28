<?php

use Faker\Generator as Faker;
use App\SelfiePhotoSamples;
$factory->define(SelfiePhotoSamples::class, function (Faker $faker) {
    return [

        'title'  =>'title',
        'image_path' =>  'image_path',

    ];
});
