<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternalAudit extends Model
{
    protected $fillable = [
        'site_id',
        'vessel_id',
        'start_date',
        'completion_date',
        'port_id',
        'location',
        'country_id',
        'no_of_issued_deficiencies',
        'audit_type_id',
        'other_audit_type',
        'from',
        'to',
        'reportpath',
    ];

    public function port()
    {
        return $this->belongsTo(ValueList::class);
    }

    public function country()
    {
        return $this->belongsTo(ValueList::class);
    }

    public function audit_type()
    {
        return $this->belongsTo(ValueList::class);
    }

    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }

    public function internal_audit_deficiencies()
    {
        return $this->hasMany(InternalAuditDeficiency::class);
    }
}
