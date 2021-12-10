<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternalAuditDeficiency extends Model
{
    protected $fillable = [
        'serial_no',
        'issued_date',
        'reference_no',
        'deficiency_nature',
        'target_date',
        'completion_date',
        'verification_date',
        'evidencepath',
        'details',
    ];

    public function internal_audit()
    {
        return $this->belongsTo(InternalAudit::class);
    }
}
