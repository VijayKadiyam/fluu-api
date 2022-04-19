<?php

namespace Tests\Feature;

use App\Site;
use App\UserSwipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSwipeTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(UserSwipe::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'user_id' => 1,
            'no_of_swipes' => 'no_of_swipes',
            'date' => 'date',
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/user_swipes', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "user_id"        =>  ["The user id field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_user_swipes()
    {
        $this->disableEH();
        $this->json('post', '/api/user_swipes', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'user_id' => 1,
                    'no_of_swipes' => 'no_of_swipes',
                    'date' => 'date',
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'user_id',
                    'no_of_swipes',
                    'date',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_user_swipes()
    {
        $this->disableEH();
        $this->json('GET', '/api/user_swipes', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'user_id',
                        'no_of_swipes',
                        'date',
                    ]
                ]
            ]);
        $this->assertCount(1, UserSwipe::all());
    }

    /** @test */
    function show_single_user_swipes()
    {

        $this->json('get', "/api/user_swipes/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'user_id' => 1,
                    'no_of_swipes' => 'no_of_swipes',
                    'date' => 'date',
                ]
            ]);
    }

    /** @test */
    function update_single_user_swipes()
    {
        $payload = [
            'user_id' => 'user_id',
            'no_of_swipes' => 'no_of_swipes',
            'date' => 'date',
        ];

        $this->json('patch', '/api/user_swipes/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'user_id' => 'user_id',
                    'no_of_swipes' => 'no_of_swipes',
                    'date' => 'date',
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'user_id',
                    'no_of_swipes',
                    'date',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
    /** @test */
    function delete_user_swipes()
    {
        $this->json('delete', '/api/user_swipes/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, UserSwipe::all());
    }
}
