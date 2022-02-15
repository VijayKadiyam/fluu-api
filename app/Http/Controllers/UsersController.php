<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;

// use App\Value;

class UsersController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'site'])
      ->except(['registerUser', 'registerUserByPhone']);
  }

  /*
   * To get all the users
   *
   *@
   */
  public function index(Request $request)
  {
    // $role = 3;
    $users = [];
    $users = $request->site->users()->with('roles')
      ->whereHas('roles',  function ($q) {
        $q->where('name', '!=', 'Admin')
          ->where('name', '!=', 'Super Admin')
          ->where('name', '!=', 'Main Admin');
      })->latest()->get();
    // if ($request->search == 'all')
    //   $users = $request->site->users()->with('roles')
    //     ->whereHas('roles',  function ($q) {
    //       $q->where('name', '!=', 'Admin');
    //     })->latest()->get();
    // else if ($request->role_id) {
    //   $role = Role::find($request->role_id);
    //   $users = $request->site->users()
    //     ->whereHas('roles', function ($q) use ($role) {
    //       $q->where('name', '=', $role->name);
    //     })->latest()->get();
    // }

    return response()->json([
      'data'  =>  $users
    ], 200);
  }

  /*
   * To store a new site user
   *
   *@
   */
  public function store(Request $request)
  {
    $request->validate([
      'first_name' =>  ['required', 'string', 'max:255'],
      // 'email'     =>  ['required', 'string', 'email', 'max:255', 'unique:users'],
      'email'     =>  ['required', 'string', 'email', 'max:255'],
      'active'    =>  ['required'],
      'role_id'   =>  ['required'],
      'site_id'   =>  ['required'],
    ]);

    // Save User
    $user  = $request->all();
    $user['password'] = bcrypt('123456');
    $user = new User($user);
    $user->save();


    if ($request->role_id)
      $user->assignRole($request->role_id);
    if ($request->site_id)
      $user->assignSite($request->site_id);

    $user->roles = $user->roles;
    $user->sites = $user->sites;

    return response()->json([
      'data'      =>  $user,
      'success'   =>  true
    ], 201);
  }

  public function registerUserByPhone(Request $request)
  {
    $request->validate([
      'phone'         => ['required'],
    ]);

    $user = User::where('phone', '=', $request->phone)
      ->first();
    if (!isset($user)) {
      $us = $request->all();
      if (isset($us['password']))
        $us['password'] = Hash::make($us['password']);
      else
        $us['password'] = Hash::make('123456');
      $us['active'] = 1;
      $user = new User($us);
      $user->api_token = str_random(60);
      $user->save();

      $user->assignRole(4);
      $user->assignSite(1);
    } else {
      if ($user->api_token == null)
        $user->api_token = str_random(60);
      $user->update($request->all());
    }
    $user->roles = $user->roles;
    $user->sites = $user->sites;
    return response()->json([
      'data'     =>  $user,
      'success'   =>  true,
      'currentAndroidVersionFromApi' =>  '1.0.0',
    ], 201);
  }

  /*
   * To show particular user
   *
   *@
   */
  public function show($id)
  {
    $user = User::where('id', '=', $id)
      ->first();

    $user->roles = $user->roles;
    $user->sites = $user->sites;
    $user->user_images = $user->user_images;

    return response()->json([
      'data'  =>  $user,
      'success' =>  true
    ], 200);
  }

  /*
   * To update user details
   *
   *@
   */
  public function update(Request $request, User $user)
  {
    $user->update($request->all());
    
    if ($request->role_id)
      $user->assignRole($request->role_id);

    $user->roles = $user->roles;
    $user->sites = $user->sites;

    return response()->json([
      'data'  =>  $user,
      'success' =>  true
    ], 200);
  }
}
