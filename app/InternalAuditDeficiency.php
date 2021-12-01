<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternalAuditDeficiency extends Model
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

    public function internal_audit()
    {
        return $this->belongsTo(InternalAudit::class);
    }
}
