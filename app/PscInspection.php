<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PscInspection extends Model
{
    protected $fillable = [
        'vessel_id',
        'date',
        'port_id',
        'country_id',
        'deficiency_id',
        'is_detained',
        'reportpath',
        'is_deficiency_closed',
        'date_of_closure',
        'evidencepath',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
    public function port()
    {
        return $this->belongsTo(ValueList::class);
    }
    public function country()
    {
        return $this->belongsTo(ValueList::class);
    }
    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }
}
