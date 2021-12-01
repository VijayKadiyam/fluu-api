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

    public function site()
    {
        return $this->belongsTo(Site::class);
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
