<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FscInspectionDeficiency extends Model
{
    protected $fillable = [
        'serial_no',
        'date_of_closure',
        'evidencepath1',
        'evidencepath2',
        'evidencepath3',
        'evidencepath4',
        'details',
    ];

    public function fsc_inspection()
    {
        return $this->belongsTo(FscInspection::class);
    }
}
