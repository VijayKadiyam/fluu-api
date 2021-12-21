<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStory extends Model
{
    protected $fillable = [
        'user_id',
        'is_active',
        'image_path',
        'video_path',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
