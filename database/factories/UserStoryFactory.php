<?php

use App\UserStory;
use Faker\Generator as Faker;

$factory->define(UserStory::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'is_active' =>         true,
        'image_path' =>         'image_path',
        'video_path' =>         'video_path',
        'date' =>         'date',
    ];
});
