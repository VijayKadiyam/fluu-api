<?php

use Faker\Generator as Faker;
use App\UserImage;
$factory->define(UserImage::class, function (Faker $faker) {
    return [
        'source'=>'source',
        'image_path'=>'image_path',
        'reference_image_path'=>'reference_image_path'
    ];
});
