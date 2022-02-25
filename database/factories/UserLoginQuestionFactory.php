<?php

use App\UserLoginQuestion;
use Faker\Generator as Faker;

$factory->define(UserLoginQuestion::class, function (Faker $faker) {
    return [
        // 'login_question_id' => 1,
        'user_id' =>         1,
        'answer' =>         'answer',
        'selected_option' => 1,
        'Image_option_1'=>'Image_option_1',
        'Image_option_2'=>'Image_option_2',
        'Image_option_3'=>  'Image_option_3',
        'Image_option_4'=>'Image_option_4',
    ];
});
