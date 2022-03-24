<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSwipe extends Model
{
    protected $fillable = [
        'user_id',
        'no_of_swipes',
        'date',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
