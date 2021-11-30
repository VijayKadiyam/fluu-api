<?php

namespace Tests\Feature;

use App\Port;
use App\Site;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PortTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(Port::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'port_name' => 'Port Name',
            'country_id' => 1,
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/ports', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "port_name"        =>  ["The port name field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_port()
    {
        $this->json('post', '/api/ports', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'port_name' => 'Port Name',
                    'country_id' => 1,
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'port_name',
                    'country_id',
                    'site_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_ports()
    {
        $this->disableEH();
        $this->json('GET', '/api/ports', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'port_name',
                        'country_id',
                    ]
                ]
            ]);
        $this->assertCount(1, Port::all());
    }

    /** @test */
    function show_single_port()
    {

        $this->json('get', "/api/ports/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'port_name' => 'Port Name',
                    'country_id' => 1,
                ]
            ]);
    }

    /** @test */
    function update_single_port()
    {
        $payload = [
            'port_name' => 'Port Name Updated',
            'country_id' => 2,
        ];

        $this->json('patch', '/api/ports/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'port_name' => 'Port Name Updated',
                    'country_id' => 2,
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'port_name',
                    'country_id',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /** @test */
    function delete_port()
    {
        $this->json('delete', '/api/ports/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, Port::all());
    }
}
