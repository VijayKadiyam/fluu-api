<?php

namespace Tests\Feature;

use App\ChartererInspection;
use App\Site;
use App\Vessel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChartererInspectionTest extends TestCase
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
        factory(ChartererInspection::class)->create([
            'vessel_id' =>  $this->vessel->id
        ]);

        $this->payload = [
            'vessel_id' => 1,
            'site_id' => 1,
            'date' => "date1",
            'port_id' => 1,
            'country_id' => 1,
            'no_of_issued_deficiencies' => 1,
            'no_of_closed_deficiencies' => 1,
            'reportpath' => "reportpath",
            'is_deficiency_closed' => 0,
            'additional_comments' => 'Additional Comments',
            'charterer_inspection_deficiencies' => [
                0 => [
                    'serial_no' => "1",
                    'date_of_closure' => "date_of_closure",
                    'evidencepath1' => "evidencepath1",
                    'evidencepath2' => "evidencepath2",
                    'evidencepath3' => "evidencepath3",
                    'evidencepath4' => "evidencepath4",
                    'details' => "details",
                ]
            ],
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/vessels/' . $this->vessel->id . '/charterer_inspections', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "date"        =>  ["The date field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_charterer_inspection()
    {
        // dd($this->payload);
        $this->disableEH();
        $this->json('post', '/api/vessels/' . $this->vessel->id . '/charterer_inspections', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'vessel_id' => 1,
                    'site_id' => 1,
                    'date' => "date1",
                    'port_id' => 1,
                    'country_id' => 1,
                    'no_of_issued_deficiencies' => 1,
                    'no_of_closed_deficiencies' => 1,
                    'reportpath' => "reportpath",
                    'is_deficiency_closed' => 0,
                    'additional_comments' => 'Additional Comments',
                    'charterer_inspection_deficiencies' => [
                        0 => [
                            'serial_no' => 1,
                            'date_of_closure' => "date_of_closure",
                            'evidencepath1' => "evidencepath1",
                            'evidencepath2' => "evidencepath2",
                            'evidencepath3' => "evidencepath3",
                            'evidencepath4' => "evidencepath4",
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
                    'additional_comments',
                    'updated_at',
                    'created_at',
                    'id',
                    'charterer_inspection_deficiencies',
                ]
            ]);
    }

    /** @test */
    function list_of_charterer_inspections()
    {
        $this->disableEH();
        $this->json('GET', '/api/vessels/' . $this->vessel->id . '/charterer_inspections', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'site_id',
                        'vessel_id',
                        'date',
                        'port_id',
                        'country_id',
                        'no_of_issued_deficiencies',
                        'no_of_closed_deficiencies',
                        'reportpath',
                        'is_deficiency_closed',
                        'additional_comments',
                    ]
                ]
            ]);
        $this->assertCount(1, ChartererInspection::all());
    }

    /** @test */
    function show_single_charterer_inspection()
    {

        $this->json('get', '/api/vessels/' . $this->vessel->id . '/charterer_inspections/1', [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'vessel_id' => 1,
                    'site_id' => 1,
                    'date' => "date1",
                    'port_id' => 1,
                    'country_id' => 1,
                    'no_of_issued_deficiencies' => 1,
                    'no_of_closed_deficiencies' => 1,
                    'reportpath' => "reportpath",
                    'is_deficiency_closed' => 0,
                    'additional_comments' => 'Additional Comments',
                ]
            ]);
    }

    /** @test */
    function update_single_charterer_inspection()
    {
        $payload = [
            'vessel_id' => 1,
            'site_id' => 1,
            'date' => "date2",
            'port_id' => 2,
            'country_id' => 2,
            'no_of_issued_deficiencies' => 2,
            'no_of_closed_deficiencies' => 2,
            'reportpath' => "reportpath 1",
            'is_deficiency_closed' => 0,
            'additional_comments' => 'Additional Comments 1',
        ];

        $this->json('patch', '/api/charterer_inspections/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'vessel_id' => 1,
                    'site_id' => 1,
                    'date' => "date2",
                    'port_id' => 2,
                    'country_id' => 2,
                    'no_of_issued_deficiencies' => 2,
                    'no_of_closed_deficiencies' => 2,
                    'reportpath' => "reportpath 1",
                    'is_deficiency_closed' => 0,
                    'additional_comments' => 'Additional Comments 1',
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
                    'reportpath',
                    'is_deficiency_closed',
                    'additional_comments',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /** @test */
    function delete_charterer_inspection()
    {
        $this->json('delete', '/api/charterer_inspections/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, ChartererInspection::all());
    }
}
