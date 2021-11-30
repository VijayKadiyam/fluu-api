<?php

namespace Tests\Feature;

use App\FscInspection;
use App\Site;
use App\Vessel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FscInspectionTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        $this->vessel = factory(Vessel::class)->create([
            'site_id' =>  $this->site->id
        ]);
        factory(FscInspection::class)->create([
            'vessel_id' =>  $this->vessel->id
        ]);

        $this->payload = [
            'vessel_id' => $this->vessel->id,
            'site_id' => $this->site->id,
            'date' => "date",
            'port_id' => 1,
            'country_id' => 1,
            'no_of_issued_deficiencies' => 1,
            'no_of_closed_deficiencies' => 1,
            'reportpath' => "reportpath",
            'is_deficiency_closed' => 0,
            'fsc_inspection_deficiencies' => [
                0 => [
                    'serial_no' => '1',
                    'date_of_closure' => "date_of_closure",
                    'evidencepath1' => "evidencepath1",
                    'details' => "details",
                ]
            ],
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/vessels/' . $this->vessel->id . '/fsc_inspections', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "date"        =>  ["The date field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_fsc_inspection()
    {
        // dd($this->payload);
        $this->disableEH();
        $this->json('post', '/api/vessels/' . $this->vessel->id . '/fsc_inspections', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'vessel_id' => $this->vessel->id,
                    'site_id' => $this->site->id,
                    'date' => "date",
                    'port_id' => 1,
                    'country_id' => 1,
                    'no_of_issued_deficiencies' => 1,
                    'no_of_closed_deficiencies' => 1,
                    'reportpath' => "reportpath",
                    'is_deficiency_closed' => 0,
                    'fsc_inspection_deficiencies' => [
                        0 => [
                            'serial_no' => '1',
                            'date_of_closure' => "date_of_closure",
                            'evidencepath1' => "evidencepath1",
                            'details' => "details",
                        ]
                    ],
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'vessel_id',
                    'site_id',
                    'date',
                    'port_id',
                    'country_id',
                    'no_of_issued_deficiencies',
                    'no_of_closed_deficiencies',
                    'reportpath',
                    'is_deficiency_closed',
                    'updated_at',
                    'created_at',
                    'id',
                    'fsc_inspection_deficiencies',
                ]
            ]);
    }

    /** @test */
    function list_of_fsc_inspections()
    {
        $this->disableEH();
        $this->json('GET', '/api/vessels/' . $this->vessel->id . '/fsc_inspections', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'vessel_id',
                        'date',
                        'port_id',
                        'country_id',
                        'is_deficiency_closed',
                        'no_of_issued_deficiencies',
                        'no_of_closed_deficiencies',
                        'reportpath',
                    ]
                ]
            ]);
        $this->assertCount(1, FscInspection::all());
    }

    /** @test */
    function show_single_fsc_inspection()
    {

        $this->json('get', '/api/vessels/' . $this->vessel->id . '/fsc_inspections/1', [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'vessel_id' => $this->vessel->id,
                    'site_id' => $this->site->id,
                    'date' => 'date',
                    'port_id' => 1,
                    'country_id' => 1,
                    'no_of_issued_deficiencies' => 'no_of_issued_deficiencies',
                    'no_of_closed_deficiencies' => 'no_of_closed_deficiencies',
                    'is_detained' => 0,
                    'reportpath' => "reportpath",
                    'is_deficiency_closed' => 0,
                ]
            ]);
    }

    /** @test */
    function update_single_fsc_inspection()
    {
        $payload = [
            'vessel_id' => $this->vessel->id,
            'site_id' => $this->site->id,
            'date' => "date",
            'port_id' => 1,
            'country_id' => 1,
            'no_of_issued_deficiencies' => 1,
            'no_of_closed_deficiencies' => 1,
            'is_detained' => 0,
            'reportpath' => "reportpath",
            'is_deficiency_closed' => 0,
        ];

        $this->json('patch', '/api/fsc_inspections/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'vessel_id' => $this->vessel->id,
                    'site_id' => $this->site->id,
                    'date' => "date",
                    'port_id' => 1,
                    'country_id' => 1,
                    'no_of_issued_deficiencies' => 1,
                    'no_of_closed_deficiencies' => 1,
                    'is_detained' => 0,
                    'reportpath' => "reportpath",
                    'is_deficiency_closed' => 0,
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
                    'no_of_issued_deficiencies',
                    'no_of_closed_deficiencies',
                    'is_detained',
                    'is_deficiency_closed',
                    'reportpath',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /** @test */
    function delete_fsc_inspection()
    {
        $this->json('delete', '/api/fsc_inspections/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, FscInspection::all());
    }
}
