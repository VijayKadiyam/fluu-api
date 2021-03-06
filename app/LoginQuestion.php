<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginQuestion extends Model
{
    protected $fillable = [
        'description',
        'is_active',
        'is_mcq',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'description_image_1',
        'image_option_1',
        'image_option_2',
        'image_option_3',
        'image_option_4',
        'is_text',
        'is_voice',
        'is_video',
        'sub_description'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function user_login_questions()
    {
        return $this->hasMany(UserLoginQuestion::class)->with('login_question', 'user');
    }
}
