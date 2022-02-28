<?php

use App\SelfiePhotoSample;
use Faker\Generator as Faker;

$factory->define(SelfiePhotoSample::class, function (Faker $faker) {
    return [
        'title'  => 'title',
        'image_path' =>  'image_path',
    ];
});
