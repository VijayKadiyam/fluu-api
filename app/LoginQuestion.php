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
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
