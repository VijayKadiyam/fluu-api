<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChartererInspection extends Model
{
    protected $fillable = [
        'vessel_id',
        'site_id',
        'date',
        'port_id',
        'country_id',
        'no_of_issued_deficiencies',
        'no_of_closed_deficiencies',
        'reportpath',
        'is_deficiency_closed',
        'date_of_closure',
        'evidencepath',
        'additional_comments',
        'charterer_name',
    ];

    // public function site()
    // {
    //     return $this->belongsTo(Site::class);
    // }
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

    public function charterer_inspection_deficiencies()
    {
        return $this->hasMany(ChartererInspectionDeficiency::class);
    }
}
