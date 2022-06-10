<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLike extends Model
{
    protected $fillable = [
        'user_id',
        'liked_user_id',
        'action'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function liked_user()
    {
        return $this->belongsTo(User::class, 'liked_user_id');
    }
}
