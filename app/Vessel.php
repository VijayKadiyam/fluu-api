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

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
