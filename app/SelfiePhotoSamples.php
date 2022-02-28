<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelfiePhotoSamples extends Model
{
    protected $fillable = [
        'site_id',
        'title',
        'image_path'
        
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
