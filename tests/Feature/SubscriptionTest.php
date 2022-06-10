<?php

namespace Tests\Feature;

use App\Site;
use App\Subscription;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(Subscription::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'subscription_name' => "subscription_name",
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/subscriptions', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "subscription_name"        =>  ["The subscription name field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_subscriptions()
    {
        $this->disableEH();
        $this->json('post', '/api/subscriptions', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    "subscription_name" => "subscription_name"

                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'subscription_name',
                    'site_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_subscriptions()
    {
        $this->disableEH();
        $this->json('GET', '/api/subscriptions', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'subscription_name',
                    ]
                ]
            ]);
        $this->assertCount(1, Subscription::all());
    }

    /** @test */
    function show_single_subscriptions()
    {

        $this->json('get', "/api/subscriptions/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    "subscription_name" => "subscription_name"

                ]
            ]);
    }

    /** @test */
    function update_single_subscriptions()
    {
        $payload = [
            "subscription_name" => "subscription_name"

        ];

        $this->json('patch', '/api/subscriptions/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    "subscription_name" => "subscription_name"
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'subscription_name',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
    /** @test */
    function delete_subscriptions()
    {
        $this->json('delete', '/api/subscriptions/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, Subscription::all());
    }
}
