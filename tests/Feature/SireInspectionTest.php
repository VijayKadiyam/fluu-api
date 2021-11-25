<?php

namespace Tests\Feature;

use App\SireInspection;
use App\SireInspectionDetail;
use App\Site;
use App\Vessel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SireInspectionTest extends TestCase
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

        factory(SireInspection::class)->create([
            'vessel_id' =>  $this->vessel->id
        ]);

        $this->payload = [
            // 'site_id' =>  $this->site->id,
            'vessel_id' => 1,
            'inspection_type' => "inspection_type",
            'inspection_type_detail' => "inspection_type_detail",
            'oil_major_id' => 1,
            'date_of_inspection' => "date_of_inspection",
            'inspector_id' => 1,
            'total_observations' => "total_observations",
            'attachment' => "attachment",
            'port_id' => 1,
            'country_id' => 1,
            'address' => "address",
            'sire_inspection_details'  =>  [
                0 =>  [
                    'sire_inspection_id' => "2",
                    'serial_no' => "1",
                    'details' => "details",
                ]
            ],
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/vessels/' . $this->vessel->id . '/sire_inspections', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "inspection_type"        =>  ["The inspection type field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_sire_inspection()
    {
        $this->disableEH();
        $this->json('post', '/api/vessels/' . $this->vessel->id . '/sire_inspections', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    // 'site_id' =>  $this->site->id,
                    'vessel_id' => 1,
                    'inspection_type' => "inspection_type",
                    'inspection_type_detail' => "inspection_type_detail",
                    'oil_major_id' => 1,
                    'date_of_inspection' => "date_of_inspection",
                    'inspector_id' => 1,
                    'total_observations' => "total_observations",
                    'attachment' => "attachment",
                    'port_id' => 1,
                    'country_id' => 1,
                    'address' => "address",
                    'sire_inspection_details'  =>  [
                        0 =>  [
                            'sire_inspection_id' => "2",
                            'serial_no' => "1",
                            'details' => "details",
                        ]
                    ],
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'vessel_id',
                    'inspection_type',
                    'inspection_type_detail',
                    'oil_major_id',
                    'date_of_inspection',
                    'inspector_id',
                    'total_observations',
                    'attachment',
                    'port_id',
                    'country_id',
                    'address',
                    // 'site_id',
                    'updated_at',
                    'created_at',
                    'id',
                    'sire_inspection_details',
                ]
            ]);
    }

    /** @test */
    function list_of_sire_inspections()
    {
        $this->disableEH();
        $this->json('GET', '/api/vessels/' . $this->vessel->id . '/sire_inspections', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'vessel_id',
                        'inspection_type',
                        'inspection_type_detail',
                        'oil_major_id',
                        'date_of_inspection',
                        'inspector_id',
                        'total_observations',
                        'attachment',
                        'port_id',
                        'country_id',
                        'address',
                    ]
                ]
            ]);
        $this->assertCount(1, SireInspection::all());
    }

    /** @test */
    function show_single_sire_inspection()
    {

        $this->json('get', "/api/vessels/' . $this->vessel->id . '/sire_inspections/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'vessel_id' => 1,
                    'inspection_type' => "inspection_type",
                    'inspection_type_detail' => "inspection_type_detail",
                    'oil_major_id' => 1,
                    'date_of_inspection' => "date_of_inspection",
                    'inspector_id' => 1,
                    'total_observations' => "total_observations",
                    'attachment' => "attachment",
                    'port_id' => 1,
                    'country_id' => 1,
                    'address' => "address",
                ]
            ]);
    }

    // /** @test */
    // function update_single_sire_inspection()
    // {
    //     $payload = [
    //         'vessel_id' => 1,
    //         'inspection_type' => "inspection_type",
    //         'inspection_type_detail' => "inspection_type_detail",
    //         'oil_major_id' => 1,
    //         'date_of_inspection' => "date_of_inspection",
    //         'inspector_id' => 1,
    //         'total_observations' => "total_observations",
    //         'attachment' => "attachment",
    //         'port_id' => 1,
    //         'country_id' => 1,
    //         'address' => "address",
    //     ];

    //     $this->json('patch', '/api/vessels/' . $this->vessel->id . '/sire_inspections/1', $payload, $this->headers)
    //         ->assertStatus(200)
    //         ->assertJson([
    //             'data'    => [
    //                 'vessel_id' => 1,
    //                 'inspection_type' => "inspection_type",
    //                 'inspection_type_detail' => "inspection_type_detail",
    //                 'oil_major_id' => 1,
    //                 'date_of_inspection' => "date_of_inspection",
    //                 'inspector_id' => 1,
    //                 'total_observations' => "total_observations",
    //                 'attachment' => "attachment",
    //                 'port_id' => 1,
    //                 'country_id' => 1,
    //                 'address' => "address",
    //             ]
    //         ])
    //         ->assertJsonStructureExact([
    //             'data'  => [
    //                 'id',
    //                 'site_id',
    //                 'vessel_id',
    //                 'inspection_type',
    //                 'inspection_type_detail',
    //                 'oil_major_id',
    //                 'date_of_inspection',
    //                 'inspector_id',
    //                 'total_observations',
    //                 'attachment',
    //                 'port_id',
    //                 'country_id',
    //                 'address',
    //                 'created_at',
    //                 'updated_at',
    //             ]
    //         ]);
    // }
    /** @test */
    function update_single_sire_inspection()
    {
        $this->disableEH();
        $sire_inspection = factory(SireInspection::class)->create([
            'vessel_id' =>  $this->vessel->id
        ]);
        $sire_inspectionDetail = factory(SireInspectionDetail::class)->create([
            'sire_inspection_id' =>  $sire_inspection->id
        ]);
        // Old Edit + No Delete + 1 New
        $payload = [
            'vessel_id' => 1,
            'inspection_type' => "inspection_type",
            'inspection_type_detail' => "inspection_type_detail",
            'oil_major_id' => 1,
            'date_of_inspection' => "date_of_inspection",
            'inspector_id' => 1,
            'total_observations' => "total_observations",
            'attachment' => "attachment",
            'port_id' => 1,
            'country_id' => 1,
            'address' => "address",
            'sire_inspection_details'  =>  [
                0 =>  [
                    // 'id' => $sire_inspectionDetail->id,
                    'serial_no' => '1',
                    'details' => "details",
                ],
                1 =>  [
                    'serial_no' => '1',
                    'details' => "details",
                ]
            ],
        ];

        $this->json('post', '/api/vessels/' . $this->vessel->id . '/sire_inspections', $payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'    => [
                    'vessel_id' => 1,
                    'inspection_type' => "inspection_type",
                    'inspection_type_detail' => "inspection_type_detail",
                    'oil_major_id' => 1,
                    'date_of_inspection' => "date_of_inspection",
                    'inspector_id' => 1,
                    'total_observations' => "total_observations",
                    'attachment' => "attachment",
                    'port_id' => 1,
                    'country_id' => 1,
                    'address' => "address",
                    'sire_inspection_details'  =>  [
                        0 =>  [
                            // 'id' => $sire_inspectionDetail->id,
                            'serial_no' => '1',
                            'details' => "details",
                        ],
                        1 =>  [
                            'serial_no' => '1',
                            'details' => "details",
                        ]
                    ],
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'vessel_id',
                    'inspection_type',
                    'inspection_type_detail',
                    'oil_major_id',
                    'date_of_inspection',
                    'inspector_id',
                    'total_observations',
                    'attachment',
                    'port_id',
                    'country_id',
                    'address',
                    // 'site_id',
                    'updated_at',
                    'created_at',
                    'id',
                    'sire_inspection_details',
                ]
            ]);

        // 1 Delete + 1 New
        $payload = [
            'id'          =>  $sire_inspection->id,
            'vessel_id' => 1,
            'inspection_type' => "inspection_type",
            'inspection_type_detail' => "inspection_type_detail",
            'oil_major_id' => 1,
            'date_of_inspection' => "date_of_inspection",
            'inspector_id' => 1,
            'total_observations' => "total_observations",
            'attachment' => "attachment",
            'port_id' => 1,
            'country_id' => 1,
            'address' => "address",
            'sire_inspection_details'  =>  [
                0 =>  [
                    'id' => $sire_inspectionDetail->id,
                    'serial_no' => '1',
                    'details' => "details",
                ],
            ],
        ];

        $this->json('post', '/api/vessels/' . $this->vessel->id . '/sire_inspections', $payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'    =>  [
                    'id'          =>  $sire_inspection->id,
                    'vessel_id' => 1,
                    'inspection_type' => "inspection_type",
                    'inspection_type_detail' => "inspection_type_detail",
                    'oil_major_id' => 1,
                    'date_of_inspection' => "date_of_inspection",
                    'inspector_id' => 1,
                    'total_observations' => "total_observations",
                    'attachment' => "attachment",
                    'port_id' => 1,
                    'country_id' => 1,
                    'address' => "address",
                    'sire_inspection_details'  =>  [
                        0 =>  [
                            'id' => $sire_inspectionDetail->id,
                            'serial_no' => '1',
                            'details' => "details",
                        ],
                    ],
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    // 'site_id',
                    'vessel_id',
                    'inspection_type',
                    'inspection_type_detail',
                    'oil_major_id',
                    'date_of_inspection',
                    'inspector_id',
                    'total_observations',
                    'attachment',
                    'port_id',
                    'country_id',
                    'address',
                    'created_at',
                    'updated_at',
                    'site_id',
                    'sire_inspection_details',
                ]
            ]);
    }

    /** @test */
    function delete_sire_inspection()
    {
        $this->json('delete', '/api/sire_inspections/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, SireInspection::all());
    }
}
