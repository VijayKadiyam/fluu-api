<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelfiePhotoSample extends Model
{
    protected $fillable = [
        'site_id',
        'title',
        'image_path'
        
    ];
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

}
