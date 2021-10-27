<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViqChapter extends Model
{
    protected $fillable = [
        'serial_no',
        'chapter_name'
    ];

    public function site() {
        return $this->belongsTo(Site::class);
    }
}
