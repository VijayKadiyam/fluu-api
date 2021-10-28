<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SireInspectionDetail extends Model
{
    protected $fillable = [
        'viq_chapter_id',
        'serial_no',
        'details',
    ];
    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }
    public function sire_inspection()
    {
        return $this->belongsTo(SireInspection::class);
    }
}
