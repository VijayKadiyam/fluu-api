<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NearMiss extends Model
{
    protected $fillable = [
        'number_reported',
        'vessel_id',
        'site_id',
        'location_id',
        'category_id',
        'activity_id',
        'basic_cause_id',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }

    public function location()
    {
        return $this->belongsTo(ValueList::class);
    }

    public function category()
    {
        return $this->belongsTo(ValueList::class);
    }

    public function activity()
    {
        return $this->belongsTo(ValueList::class);
    }
    
    public function basic_cause()
    {
        return $this->belongsTo(ValueList::class);
    }
}
