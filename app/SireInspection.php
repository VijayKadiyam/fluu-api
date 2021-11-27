<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SireInspection extends Model
{
    protected $fillable = [
        'vessel_id',
        'inspection_type',
        'inspection_type_detail',
        'oil_major_id',
        'date_of_inspection',
        'inspector_id',
        'total_observations',
        'attachment',
        'port_id',
        'country_id',
        'address',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }
    public function sire_inspection_details()
    {
        return $this->hasMany(SireInspectionDetail::class)->with('viq_chapter');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function port()
    {
        return $this->belongsTo(ValueList::class);
    }
    public function country()
    {
        return $this->belongsTo(ValueList::class);
    }
    public function oil_major()
    {
        return $this->belongsTo(ValueList::class);
    }
    public function inspector()
    {
        return $this->belongsTo(User::class);
    }
}
