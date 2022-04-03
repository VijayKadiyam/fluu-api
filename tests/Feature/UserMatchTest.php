<?php

namespace Tests\Feature;

use App\Site;
use App\UserMatch;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserMatchTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(UserMatch::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'user_id' => 1,
            'matched_user_id' => 1,
            'date' => 'date',
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/user_matches', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "user_id"        =>  ["The user id field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_user_matches()
    {
        $this->disableEH();
        $this->json('post', '/api/user_matches', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'user_id' => 1,
                    'matched_user_id' => 1,
                    'date' => 'date',
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'user_id',
                    'matched_user_id',
                    'date',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_user_matches()
    {
        $this->disableEH();
        $this->json('GET', '/api/user_matches', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'user_id',
                        'matched_user_id',
                        'date',
                    ]
                ]
            ]);
        $this->assertCount(1, UserMatch::all());
    }

    /** @test */
    function show_single_user_match()
    {

        $this->json('get', "/api/user_matches/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'user_id' => 1,
                    'matched_user_id' => 1,
                    'date' => 'date',
                ]
            ]);
    }

    /** @test */
    function update_single_user_matches()
    {
        $payload = [
            'user_id' => 'user_id',
            'matched_user_id' => 1,
            'date' => 'date',
        ];

        $this->json('patch', '/api/user_matches/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'user_id' => 'user_id',
                    'matched_user_id' => 1,
                    'date' => 'date',
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'user_id',
                    'matched_user_id',
                    'date',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
    /** @test */
    function delete_user_matches()
    {
        $this->json('delete', '/api/user_matches/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, UserMatch::all());
    }
}
