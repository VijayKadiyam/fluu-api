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
        'description_image_1'=>'description_image_1',
        'image_option_1'=>'image_option_1',
        'image_option_2'=>'image_option_2',
        'image_option_3'=>'image_option_3',
        'image_option_4'=>'image_option_4',
        'is_text' =>   true,
        'is_voice' =>   true,
        'is_video' =>   true,
        
    ];
});
