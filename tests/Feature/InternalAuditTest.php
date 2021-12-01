<?php

namespace Tests\Feature;

use App\InternalAudit;
use App\Site;
use App\Vessel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InternalAuditTest extends TestCase
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
        factory(InternalAudit::class)->create([
            'vessel_id' =>  $this->vessel->id
        ]);

        $this->payload = [
            'vessel_id' => $this->vessel->id,
            'site_id' => $this->site->id,
            'start_date' => 'start_date',
            'complition_date' => 'complition_date',
            'port_id' => 1,
            'location' => "location",
            'country_id' => 1,
            'no_of_issued_deficiencies' => 'no_of_issued_deficiencies',
            'no_of_closed_deficiencies' => 'no_of_closed_deficiencies',
            'is_deficiency_closed' => 0,
            'reportpath' => 'reportpath',
            'internal_audit_deficiencies' => [
                0 => [
                    'serial_no' => '1',
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
        $this->json('post', '/api/vessels/' . $this->vessel->id . '/internal_audits', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "start_date"        =>  ["The start date field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_internal_audit()
    {
        // dd($this->payload);
        $this->disableEH();
        $this->json('post', '/api/vessels/' . $this->vessel->id . '/internal_audits', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'vessel_id' => $this->vessel->id,
                    'site_id' => $this->site->id,
                    'start_date' => 'start_date',
                    'complition_date' => 'complition_date',
                    'port_id' => 1,
                    'location' => "location",
                    'country_id' => 1,
                    'no_of_issued_deficiencies' => 'no_of_issued_deficiencies',
                    'no_of_closed_deficiencies' => 'no_of_closed_deficiencies',
                    'is_deficiency_closed' => 0,
                    'reportpath' => 'reportpath',
                    'internal_audit_deficiencies' => [
                        0 => [
                            'serial_no' => '1',
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
                    'start_date',
                    'complition_date',
                    'port_id',
                    'location',
                    'country_id',
                    'no_of_issued_deficiencies',
                    'no_of_closed_deficiencies',
                    'is_deficiency_closed',
                    'reportpath',
                    'updated_at',
                    'created_at',
                    'id',
                    'internal_audit_deficiencies',
                ]
            ]);
    }

    /** @test */
    function list_of_internal_audits()
    {
        $this->disableEH();
        $this->json('GET', '/api/vessels/' . $this->vessel->id . '/internal_audits', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'vessel_id',
                        'start_date',
                        'complition_date',
                        'port_id',
                        'location',
                        'country_id',
                        'no_of_issued_deficiencies',
                        'no_of_closed_deficiencies',
                        'is_deficiency_closed',
                        'reportpath',
                    ]
                ]
            ]);
        $this->assertCount(1, InternalAudit::all());
    }

    /** @test */
    function show_single_internal_audit()
    {

        $this->json('get', '/api/vessels/' . $this->vessel->id . '/internal_audits/1', [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'vessel_id' => $this->vessel->id,
                    'site_id' => $this->site->id,
                    'start_date' => 'start_date',
                    'complition_date' => 'complition_date',
                    'port_id' => 1,
                    'location' => "location",
                    'country_id' => 1,
                    'no_of_issued_deficiencies' => 'no_of_issued_deficiencies',
                    'no_of_closed_deficiencies' => 'no_of_closed_deficiencies',
                    'is_deficiency_closed' => 0,
                    'reportpath' => 'reportpath',
                ]
            ]);
    }

    /** @test */
    function update_single_internal_audit()
    {
        $payload = [
            'vessel_id' => $this->vessel->id,
            'site_id' => $this->site->id,
            'start_date' => 'start_date',
            'complition_date' => 'complition_date',
            'port_id' => 1,
            'location' => "location",
            'country_id' => 1,
            'no_of_issued_deficiencies' => 'no_of_issued_deficiencies',
            'no_of_closed_deficiencies' => 'no_of_closed_deficiencies',
            'is_deficiency_closed' => 0,
            'reportpath' => 'reportpath',
        ];

        $this->json('patch', '/api/internal_audits/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'vessel_id' => $this->vessel->id,
                    'site_id' => $this->site->id,
                    'start_date' => 'start_date',
                    'complition_date' => 'complition_date',
                    'port_id' => 1,
                    'location' => "location",
                    'country_id' => 1,
                    'no_of_issued_deficiencies' => 'no_of_issued_deficiencies',
                    'no_of_closed_deficiencies' => 'no_of_closed_deficiencies',
                    'is_deficiency_closed' => 0,
                    'reportpath' => 'reportpath',
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'vessel_id',
                    'start_date',
                    'complition_date',
                    'country_id',
                    'location',
                    'port_id',
                    'no_of_issued_deficiencies',
                    'no_of_closed_deficiencies',
                    'is_deficiency_closed',
                    'reportpath',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /** @test */
    function delete_internal_audit()
    {
        $this->json('delete', '/api/internal_audits/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, InternalAudit::all());
    }
}
