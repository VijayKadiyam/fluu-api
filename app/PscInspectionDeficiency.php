<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PscInspectionDeficiency extends Model
{
    protected $fillable = [
        'serial_no',
        'date_of_closure',
        'evidencepath',
        'details',
    ];

    public function psc_inspection()
    {
        return $this->belongsTo(PscInspection::class);
    }
}
