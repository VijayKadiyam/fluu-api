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
      ->with('roles', 'sites', 'user_images', 'user_login_questions');
  }

  public function values()
  {
    return $this->hasMany(Value::class);
  }

  public function login_questions()
  {
    return $this->hasMany(LoginQuestion::class)->with('user_login_questions');
  }


  public function settings()
  {
    return $this->hasMany(Setting::class);
  }

  public function selfie_photo_samples()
  {
    return $this->hasMany(SelfiePhotoSample::class);
  }
  public function user_superlikes()
  {
    return $this->hasMany(UserSuperlike::class)->with('user','liked_user');
  }
  public function user_swipes()
  {
    return $this->hasMany(UserSwipe::class)->with('user');
  }
  public function user_matches()
  {
    return $this->hasMany(UserMatch::class)->with('user','matched_user');
  }
  public function user_subscriptions()
  {
    return $this->hasMany(UserSubscription::class)->with('user');
  }
}
