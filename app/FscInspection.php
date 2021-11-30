<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FscInspection extends Model
{
    protected $fillable = [
        'site_id',
        'vessel_id',
        'date',
        'port_id',
        'country_id',
        'no_of_issued_deficiencies',
        'no_of_closed_deficiencies',
        'is_detained',
        'is_deficiency_closed',
        'reportpath',
    ];

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

    public function fsc_inspection_deficiencies()
    {
        return $this->hasMany(FscInspectionDeficiency::class);
    }
}
