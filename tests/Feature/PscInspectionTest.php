<?php

namespace Tests\Feature;

use App\PscInspection;
use App\Site;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PscInspectionTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(PscInspection::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'vessel_id' => 1,
            'date' => "date",
            'port_id' => 1,
            'country_id' => 1,
            'deficiency_id' => 1,
            'is_detained' => 0,
            'reportpath' => "reportpath",
            'is_deficiency_closed' => 0,
            'date_of_closure' => "date_of_closure",
            'evidencepath' => "evidencepath",
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/psc_inspections', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "date"        =>  ["The date field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_viq_chapter()
    {
        $this->disableEH();
        $this->json('post', '/api/psc_inspections', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'vessel_id' => 1,
                    'date' => "date",
                    'port_id' => 1,
                    'country_id' => 1,
                    'deficiency_id' => 1,
                    'is_detained' => 0,
                    'reportpath' => "reportpath",
                    'is_deficiency_closed' => 0,
                    'date_of_closure' => "date_of_closure",
                    'evidencepath' => "evidencepath",
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'vessel_id',
                    'date',
                    'port_id',
                    'country_id',
                    'deficiency_id',
                    'is_detained',
                    'reportpath',
                    'is_deficiency_closed',
                    'date_of_closure',
                    'evidencepath',
                    'site_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_psc_inspections()
    {
        $this->disableEH();
        $this->json('GET', '/api/psc_inspections', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'vessel_id',
                        'date',
                        'port_id',
                        'country_id',
                        'deficiency_id',
                        'is_detained',
                        'reportpath',
                        'is_deficiency_closed',
                        'date_of_closure',
                        'evidencepath',
                    ]
                ]
            ]);
        $this->assertCount(1, PscInspection::all());
    }

    /** @test */
    function show_single_viq_chapter()
    {

        $this->json('get', "/api/psc_inspections/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'vessel_id' => 1,
                    'date' => "date",
                    'port_id' => 1,
                    'country_id' => 1,
                    'deficiency_id' => 1,
                    'is_detained' => 0,
                    'reportpath' => "reportpath",
                    'is_deficiency_closed' => 0,
                    'date_of_closure' => "date_of_closure",
                    'evidencepath' => "evidencepath",
                ]
            ]);
    }

    /** @test */
    function update_single_viq_chapter()
    {
        $payload = [
            'vessel_id' => 1,
            'date' => "date",
            'port_id' => 1,
            'country_id' => 1,
            'deficiency_id' => 1,
            'is_detained' => 0,
            'reportpath' => "reportpath",
            'is_deficiency_closed' => 0,
            'date_of_closure' => "date_of_closure",
            'evidencepath' => "evidencepath",
        ];

        $this->json('patch', '/api/psc_inspections/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'vessel_id' => 1,
                    'date' => "date",
                    'port_id' => 1,
                    'country_id' => 1,
                    'deficiency_id' => 1,
                    'is_detained' => 0,
                    'reportpath' => "reportpath",
                    'is_deficiency_closed' => 0,
                    'date_of_closure' => "date_of_closure",
                    'evidencepath' => "evidencepath",
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'vessel_id',
                    'date',
                    'port_id',
                    'country_id',
                    'deficiency_id',
                    'is_detained',
                    'reportpath',
                    'is_deficiency_closed',
                    'date_of_closure',
                    'evidencepath',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /** @test */
    function delete_viq_chapter()
    {
        $this->json('delete', '/api/psc_inspections/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, PscInspection::all());
    }
}
