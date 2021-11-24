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
    return $this->hasMany(NearMiss::class)->with('location', 'category', 'activity', 'basic_cause');
  }

  public function values()
  {
    return $this->hasMany(Value::class);
  }

  public function vessels()
  {
    return $this->hasMany(Vessel::class)->with('vessel_type', 'place_of_built');
  }
  public function psc_inspections()
  {
    return $this->hasMany(PscInspection::class)->with('port','country');
  }
  public function sire_inspections()
  {
    return $this->hasMany(SireInspection::class);
  }
  public function sire_inspection_details()
  {
    return $this->hasMany(SireInspectionDetail::class)->with('users');
  }
}
