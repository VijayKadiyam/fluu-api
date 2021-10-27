<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NearMiss extends Model
{
    protected $fillable = [
        'number_reported',
        'location_id',
        'category_id',
        'activity_id',
        'basic_cause_id',
    ];

    public function site() {
        return $this->belongsTo(Site::class);
    }
}
