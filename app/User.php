<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'first_name',
    'middle_name',
    'last_name',
    'user_name',
    'gender',
    'dob',
    'email',
    'password',
    'phone',
    'api_token',
    'active',
    'password',
    'gallery_image1_path',
    'gallery_image2_path',
    'gallery_image3_path',
    'gallery_image4_path',
    'interests',
    'selfie_image_path',
    'voice_clip_path',
    'zodiac_sign_id',
    'g_display_name',
    'g_email',
    'g_id',
    'g_photo_url',
    'g_server_auth_code',
    'occuption',
    'current_location',
    'is_verified',
    'login_source',
    'is_signed_in',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /*
   * To generate api token
   *
   *@
   */
  public function generateToken()
  {
    if ($this->api_token == null)
      $this->api_token = str_random(60);
    $this->save();
    return $this;
  }

  public function roles()
  {
    return $this->belongsToMany(Role::class)
      ->with('permissions');
  }
  public function assignRole($role)
  {
    return $this->roles()->sync([$role]);
  }

  public function hasRole($roles)
  {
    return $this->roles ? in_array($roles, $this->roles->pluck('id')->toArray()) : false;
  }

  public function sites()
  {
    return $this->belongsToMany(Site::class);
  }

  /**
   * Assign company to user
   *
   * @ 
   */
  public function assignSite($company)
  {
    return $this->sites()->sync([$company]);
  }

  /**
   * Check if the user has company
   *
   * @ 
   */
  public function hasSite($company)
  {
    return $this->sites ? in_array($company, $this->sites->pluck('id')->toArray()) : false;
  }

  public function permissions()
  {
    return $this->belongsToMany(Permission::class);
  }

  public function assignPermission($permission)
  {
    $this->permissions()->syncWithoutDetaching([$permission]);
    $this->refresh();

    return $this;
  }

  public function unassignPermission($permission)
  {
    $this->permissions()->detach([$permission]);
    $this->refresh();

    return $this;
  }

  public function hasPermission($permission)
  {
    return $this->permissions ? in_array($permission, $this->permissions->pluck('id')->toArray()) : false;
  }

  public function user_login_questions()
  {
    return $this->hasMany(UserLoginQuestion::class);
  }
  public function user_stories()
  {
    return $this->hasMany(UserStory::class);
  }
  public function user_notifications()
  {
    return $this->hasMany(UserNotification::class);
  }
  public function user_images()
  {
    return $this->hasMany(UserImage::class);
  }
}
