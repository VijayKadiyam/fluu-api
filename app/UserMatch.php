<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMatch extends Model
{
    protected $fillable = [
        'user_id',
        'matched_user_id',
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
    public function matched_user()
    {
        return $this->belongsTo(User::class,'matched_user_id');
    }
}
