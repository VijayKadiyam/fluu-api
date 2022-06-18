<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'subscription_name',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
