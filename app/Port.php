<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    protected $fillable = [
        'port_name',
        'country_id'
    ];

    public function site() {
        return $this->belongsTo(Site::class);
    }
}
