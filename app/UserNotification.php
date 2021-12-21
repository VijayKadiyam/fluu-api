<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $fillable = [
        'user_id',
        'notification_id',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
