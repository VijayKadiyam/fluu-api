<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    protected $fillable = [
        'serial_no',
        'name',
        'imo_no',
        'vessel_type_id',
        'built_date',
        'built_place',
        'dwt',
        'management_in_date',
        'management_out_date',
        'remarks',
        'no_of_deck_officers',
        'no_of_engine_officers',
        'no_of_deck_rating',
        'no_of_engine_rating',
        'no_of_galley_rating',
        'officer_nationalities',
        'rating_nationalities',
    ];

    protected $casts = [
        'officer_nationalities' => 'array',
        'rating_nationalities' => 'array',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function vessel_type()
    {
        return $this->belongsTo(ValueList::class);
    }
    public function place_of_built()
    {
        return $this->belongsTo(ValueList::class, 'built_place');
    }

    public function psc_inspections()
    {
        return $this->hasMany(PscInspection::class)->with('port', 'country');
    }
    public function sire_inspections()
    {
        return $this->hasMany(SireInspection::class);
    }
}
