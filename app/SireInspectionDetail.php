<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SireInspectionDetail extends Model
{
    protected $fillable = [
        'viq_chapter_id',
        'viq_no',
        'observation',

    ];
    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }
    public function sire_inspection()
    {
        return $this->belongsTo(SireInspection::class);
    }
    public function viq_chapter()
    {
        return $this->belongsTo(ViqChapter::class);
    }
}
