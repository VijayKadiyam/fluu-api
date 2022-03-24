<?php

namespace Tests\Feature;

use App\Site;
use App\UserSuperlike;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSuperlikeTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(UserSuperlike::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'user_id' => 1,
            'liked_user_id' => 1,
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/user_superlikes', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "user_id"        =>  ["The user id field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_user_superlikes()
    {
        $this->disableEH();
        $this->json('post', '/api/user_superlikes', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'user_id' => 1,
                    'liked_user_id' => 1,
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'user_id',
                    'liked_user_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_user_superlikes()
    {
        $this->disableEH();
        $this->json('GET', '/api/user_superlikes', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'user_id',
                        'liked_user_id',
                    ]
                ]
            ]);
        $this->assertCount(1, UserSuperlike::all());
    }

    /** @test */
    function show_single_user_superlikes()
    {

        $this->json('get', "/api/user_superlikes/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'user_id' => 1,
                    'liked_user_id' => 1,
                ]
            ]);
    }

    /** @test */
    function update_single_user_superlikes()
    {
        $payload = [
            'user_id' => 'user_id',
            'liked_user_id' => 1,
        ];

        $this->json('patch', '/api/user_superlikes/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'user_id' => 'user_id',
                    'liked_user_id' => 1,
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'user_id',
                    'liked_user_id',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
    /** @test */
    function delete_user_superlikes()
    {
        $this->json('delete', '/api/user_superlikes/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, UserSuperlike::all());
    }
}
