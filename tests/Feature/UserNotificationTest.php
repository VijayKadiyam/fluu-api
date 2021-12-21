<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Site;
use App\UserNotification;

class UserNotificationTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(UserNotification::class)->create([
            'user_id' =>  $this->user->id
        ]);

        $this->payload = [
            'user_id' =>  $this->user->id,
            'notification_id' =>  1,
            'is_active' =>   true,
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/user_notifications', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "user_id"        =>  ["The user id field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_user_notification()
    {
        $this->disableEH();
        $this->json('post', '/api/user_notifications', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'user_id' =>  $this->user->id,
                    'notification_id' =>  1,
                    'is_active' =>   true,
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'user_id',
                    'notification_id',
                    'is_active',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_user_notifications()
    {
        $this->disableEH();
        $this->json('GET', '/api/user_notifications?user_id='.$this->user->id.'', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'user_id',
                        'notification_id',
                        'is_active',
                    ]
                ]
            ]);
        $this->assertCount(1, UserNotification::all());
    }

    /** @test */
    function show_single_user_notification()
    {

        $this->json('get', "/api/user_notifications/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'user_id' =>  $this->user->id,
                    'notification_id' =>  1,
                    'is_active' =>   true,
                ]
            ]);
    }

    /** @test */
    function update_single_user_notification()
    {
        $payload = [
            'user_id' =>  $this->user->id,
            'notification_id' =>  1,
            'is_active' =>   true,
        ];

        $this->json('patch', '/api/user_notifications/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'user_id' =>  $this->user->id,
                    'notification_id' =>  1,
                    'is_active' =>   true,
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'user_id',
                    'notification_id',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /** @test */
    function delete_user_notification()
    {
        $this->json('delete', '/api/user_notifications/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, UserNotification::all());
    }
}
