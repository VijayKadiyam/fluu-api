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
