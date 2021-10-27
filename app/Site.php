<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
  protected $fillable = [
    'name', 'phone', 'email',
  ];

  public function users()
  {
    return $this->belongsToMany(User::class)
      ->with('roles', 'sites');
  }
  
  public function viq_chapters()
  {
    return $this->hasMany(ViqChapter::class);
  }

  public function near_misses()
  {
    return $this->hasMany(NearMiss::class);
  }
  
  public function values()
  {
    return $this->hasMany(Value::class);
  }
}
