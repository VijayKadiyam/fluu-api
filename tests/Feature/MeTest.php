<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeTest extends TestCase
{
  use DatabaseTransactions;

  /** @test */
  function get_logged_in_user()
  {
    $this->json('get', '/api/me', [], $this->headers)
      ->assertStatus(200)
      ->assertJson([
        'data'    =>  [
          'email' =>  $this->user->email,
        ]
      ])
      ->assertJsonStructureExact([
        'data'  => [
          'id',
          'first_name',
          'middle_name',
          'last_name',
          'user_name',
          'gender',
          'dob',
          'email',
          'phone',
          'api_token',
          'active',
          'gallery_image_path',
          'selfie_image_path',
          'voice_clip_path',
          'zodiac_sign_id',
          'created_at',
          'updated_at',
          'roles',
          'sites',
        ],
        'success'
      ]);
  }
}
