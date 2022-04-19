<?php

use App\Setting;
use Faker\Generator as Faker;

$factory->define(Setting::class, function (Faker $faker) {
    return [
        'banner_1_title' => 'banner_1_title',
        'banner_1_description' => 'banner_1_description',
        'banner_2_title' => 'banner_2_title',
        'banner_2_description' => 'banner_2_description',
        'banner_3_title' => 'banner_3_title',
        'banner_3_description' => 'banner_3_description',
        'audio_p_title' => 'audio_p_title',
        'audio_p_description' => 'audio_p_description',
        'current_color' => 'current_color',
        'primary_color' => 'primary_color',
        'accent_color' => 'accent_color',
        'terms_description'=>'terms_description',
        'sign_in_by_phone_description'=>'sign_in_by_phone_description',
        'otp_description'=>'otp_description',
        'gender_description'=>'gender_description',
        'gallery_page_description'=>'gallery_page_description',
        'selfie_page_description'=>'selfie_page_description',
        'video_clip_page_description'=>'video_clip_page_description',
        'questions_page_description'=>'questions_page_description',
    ];
});
