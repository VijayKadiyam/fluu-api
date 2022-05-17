<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
  return [
    'first_name'        => $faker->name,
    'middle_name'       => $faker->name,
    'last_name'         => $faker->name,
    'user_name'         => $faker->name,
    'email'             => $faker->unique()->email,
    'password'          => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
    'remember_token'    => str_random(10),
    'active'            =>  1,
    'g_display_name'            =>  'g_display_name',
    'g_email'            =>  'g_email',
    'g_id'            =>  'g_id',
    'g_photo_url'            =>  'g_photo_url',
    'g_server_auth_code'            =>  'g_server_auth_code',
    'occuption' => 'occuption',
    'current_location' => 'current_location',
    'is_verified' => 0,
    'login_source' => 'login_source',
    'is_signed_in' => 0,
    'google_uid' => 'google_uid',
    'short_bio' => 'short_bio',
  ];
});
