<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternalAudit extends Model
{
    protected $fillable = [
        'site_id',
        'vessel_id',
        'start_date',
        'complition_date',
        'port_id',
        'location',
        'country_id',
        'no_of_issued_deficiencies',
        'no_of_closed_deficiencies',
        'is_deficiency_closed',
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

    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }

    public function internal_audit_deficiencies()
    {
        return $this->hasMany(InternalAuditDeficiency::class);
    }
}
