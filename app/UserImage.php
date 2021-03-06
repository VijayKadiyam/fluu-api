<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    protected $fillable = [
        'user_id',
        'source',
        'image_path',
        'reference_image_path'
      
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
