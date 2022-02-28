<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLoginQuestion extends Model
{
    protected $fillable = [
        'login_question_id',
        'user_id',
        'answer',
        'selected_option',
        'Image_option_1',
        'Image_option_2',
        'Image_option_3',
        'Image_option_4'
    ];

    public function login_question()
    {
        return $this->belongsTo(LoginQuestion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
