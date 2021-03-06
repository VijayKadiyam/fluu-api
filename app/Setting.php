<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'banner_path_1',
        'banner_1_title',
        'banner_1_description',
        'banner_path_2',
        'banner_2_title',
        'banner_2_description',
        'banner_path_3',
        'banner_3_title',
        'banner_3_description',
        'intro_p_create_b',
        'intro_p_already_t',
        'intro_p_signin_b',
        'signinbyphone_b',
        'logo_path',
        'terms_t',
        'privacy_t',
        'siginphone_p_title',
        'siginphone_p_description',
        'otp_p_title',
        'gender_p_title',
        'woman_text',
        'man_text',
        'other_text',
        'gallery_p_title',
        'gallery_p_description',
        'selfie_p_title',
        'selfie_p_description',
        'audio_p_title',
        'audio_p_description',
        'current_color',
        'primary_color',
        'accent_color',
        'terms_description',
        'sign_in_by_phone_description',
        'otp_description',
        'gender_description',
        'gallery_page_description',
        'selfie_page_description',
        'video_clip_page_description',
        'questions_page_description',

    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
