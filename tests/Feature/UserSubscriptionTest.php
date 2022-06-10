<?php

namespace Tests\Feature;

use App\Site;
use App\UserSubscription;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSubscriptionTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(UserSubscription::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'user_id' => 1,
            'subscription_name' => 'subscription_name',
            'date' => 'date',
            'subscription_id' => 1,

        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/user_subscriptions', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "user_id"        =>  ["The user id field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_user_subscriptions()
    {
        $this->disableEH();
        $this->json('post', '/api/user_subscriptions', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'user_id' => 1,
                    'subscription_name' => 'subscription_name',
                    'date' => 'date',
                    'subscription_id' => 1,

                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'user_id',
                    'subscription_name',
                    'date',
                    'subscription_id',
                    'site_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_user_subscriptions()
    {
        $this->disableEH();
        $this->json('GET', '/api/user_subscriptions', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'user_id',
                        'subscription_name',
                        'date',
                        'subscription_id',

                    ]
                ]
            ]);
        $this->assertCount(1, UserSubscription::all());
    }

    /** @test */
    function show_single_user_subscriptions()
    {

        $this->json('get', "/api/user_subscriptions/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'user_id' => 1,
                    'subscription_name' => 'subscription_name',
                    'date' => 'date',
                    'subscription_id' => 1,

                ]
            ]);
    }

    /** @test */
    function update_single_user_subscriptions()
    {
        $payload = [
            'user_id' => 'user_id',
            'subscription_name' => 'subscription_name',
            'date' => 'date',
            'subscription_id' => 1,

        ];

        $this->json('patch', '/api/user_subscriptions/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'user_id' => 'user_id',
                    'subscription_name' => 'subscription_name',
                    'date' => 'date',
                    'subscription_id' => 1,

                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'user_id',
                    'subscription_name',
                    'date',
                    'created_at',
                    'updated_at',
                    'subscription_id',

                ]
            ]);
    }
    /** @test */
    function delete_user_subscriptions()
    {
        $this->json('delete', '/api/user_subscriptions/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, UserSubscription::all());
    }
}
