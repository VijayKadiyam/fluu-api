<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Site;
use App\User;
use App\UserStory;

class UserStoryTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(UserStory::class)->create([
            'user_id' =>  $this->user->id
        ]);

        $this->payload = [
            'user_id' =>  $this->user->id,
            'is_active' =>         true,
            'image_path' =>         'image_path',
            'video_path' =>         'video_path',
            'date' =>         'date',
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/user_stories', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "user_id"        =>  ["The user id field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_user_story()
    {
        $this->disableEH();
        $this->json('post', '/api/user_stories', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'user_id' =>  $this->user->id,
                    'is_active' =>         true,
                    'image_path' =>         'image_path',
                    'video_path' =>         'video_path',
                    'date' =>         'date',
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'user_id',
                    'is_active',
                    'image_path',
                    'video_path',
                    'date',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_user_stories()
    {
        $this->disableEH();
        $this->json('GET', '/api/user_stories?user_id=1', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'user_id',
                        'is_active',
                        'image_path',
                        'video_path',
                        'date',
                    ]
                ]
            ]);
        $this->assertCount(1, UserStory::all());
    }

    /** @test */
    function show_single_user_story()
    {

        $this->json('get', "/api/user_stories/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'user_id' =>  $this->user->id,
                    'is_active' =>         true,
                    'image_path' =>         'image_path',
                    'video_path' =>         'video_path',
                    'date' =>         'date',
                ]
            ]);
    }

    /** @test */
    function update_single_user_story()
    {
        $payload = [
            'user_id' =>  $this->user->id,
            'is_active' =>         true,
            'image_path' =>         'image_path',
            'video_path' =>         'video_path',
            'date' =>         'date',
        ];

        $this->json('patch', '/api/user_stories/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'user_id' =>  $this->user->id,
                    'is_active' =>         true,
                    'image_path' =>         'image_path',
                    'video_path' =>         'video_path',
                    'date' =>         'date',
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'user_id',
                    'is_active',
                    'image_path',
                    'video_path',
                    'date',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /** @test */
    function delete_user_story()
    {
        $this->json('delete', '/api/user_stories/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, UserStory::all());
    }
}
