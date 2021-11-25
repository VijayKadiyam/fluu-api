<?php

namespace Tests\Feature;

use App\Site;
use App\Vessel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VesselTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(Vessel::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'serial_no' => "serial_no",
            'name' => "name",
            'imo_no' => 1,
            'vessel_type_id' => 1,
            'built_date' => "built_date",
            'built_place' => "built_place",
            'dwt' => "dwt",
            'management_in_date' => "management_in_date",
            'management_out_date' => "management_out_date",
            'remarks' => "remarks",
            'no_of_deck_officers' => 1,
            'no_of_engine_officers' => 1,
            'no_of_deck_rating' => 1,
            'no_of_engine_rating' => 1,
            'no_of_galley_rating' => 1,
            'officer_nationalities' => 1,
            'rating_nationalities' => 1,
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/vessels', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "serial_no"        =>  ["The serial no field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_viq_chapter()
    {
        $this->disableEH();
        $this->json('post', '/api/vessels', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'serial_no' => "serial_no",
                    'name' => "name",
                    'imo_no' => 1,
                    'vessel_type_id' => 1,
                    'built_date' => "built_date",
                    'built_place' => "built_place",
                    'dwt' => "dwt",
                    'management_in_date' => "management_in_date",
                    'management_out_date' => "management_out_date",
                    'remarks' => "remarks",
                    'no_of_deck_officers' => 1,
                    'no_of_engine_officers' => 1,
                    'no_of_deck_rating' => 1,
                    'no_of_engine_rating' => 1,
                    'no_of_galley_rating' => 1,
                    'officer_nationalities' => 1,
                    'rating_nationalities' => 1,
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'serial_no',
                    'name',
                    'imo_no',
                    'vessel_type_id',
                    'built_date',
                    'built_place',
                    'dwt',
                    'management_in_date',
                    'management_out_date',
                    'remarks',
                    'no_of_deck_officers',
                    'no_of_engine_officers',
                    'no_of_deck_rating',
                    'no_of_engine_rating',
                    'no_of_galley_rating',
                    'officer_nationalities',
                    'rating_nationalities',
                    'site_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_vessels()
    {
        $this->disableEH();
        $this->json('GET', '/api/vessels', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'serial_no',
                        'name',
                        'imo_no',
                        'vessel_type_id',
                        'built_date',
                        'built_place',
                        'dwt',
                        'management_in_date',
                        'management_out_date',
                        'remarks',
                        'no_of_deck_officers',
                        'no_of_engine_officers',
                        'no_of_deck_rating',
                        'no_of_engine_rating',
                        'no_of_galley_rating',
                        'officer_nationalities',
                        'rating_nationalities',
                    ]
                ]
            ]);
        $this->assertCount(1, Vessel::all());
    }

    /** @test */
    function show_single_viq_chapter()
    {

        $this->json('get', "/api/vessels/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'serial_no' => "serial_no",
                    'name' => "name",
                    'imo_no' => 1,
                    'vessel_type_id' => 1,
                    'built_date' => "built_date",
                    'built_place' => "built_place",
                    'dwt' => "dwt",
                    'management_in_date' => "management_in_date",
                    'management_out_date' => "management_out_date",
                    'remarks' => "remarks",
                    'no_of_deck_officers' => 1,
                    'no_of_engine_officers' => 1,
                    'no_of_deck_rating' => 1,
                    'no_of_engine_rating' => 1,
                    'no_of_galley_rating' => 1,
                    'officer_nationalities' => 1,
                    'rating_nationalities' => 1,
                ]
            ]);
    }

    /** @test */
    function update_single_viq_chapter()
    {
        $payload = [
            'serial_no' => "serial_no",
            'name' => "name",
            'imo_no' => 1,
            'vessel_type_id' => 1,
            'built_date' => "built_date",
            'built_place' => "built_place",
            'dwt' => "dwt",
            'management_in_date' => "management_in_date",
            'management_out_date' => "management_out_date",
            'remarks' => "remarks",
            'no_of_deck_officers' => 1,
            'no_of_engine_officers' => 1,
            'no_of_deck_rating' => 1,
            'no_of_engine_rating' => 1,
            'no_of_galley_rating' => 1,
            'officer_nationalities' => 1,
            'rating_nationalities' => 1,
        ];

        $this->json('patch', '/api/vessels/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'serial_no' => "serial_no",
                    'name' => "name",
                    'imo_no' => 1,
                    'vessel_type_id' => 1,
                    'built_date' => "built_date",
                    'built_place' => "built_place",
                    'dwt' => "dwt",
                    'management_in_date' => "management_in_date",
                    'management_out_date' => "management_out_date",
                    'remarks' => "remarks",
                    'no_of_deck_officers' => 1,
                    'no_of_engine_officers' => 1,
                    'no_of_deck_rating' => 1,
                    'no_of_engine_rating' => 1,
                    'no_of_galley_rating' => 1,
                    'officer_nationalities' => 1,
                    'rating_nationalities' => 1,
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'serial_no',
                    'name',
                    'imo_no',
                    'vessel_type_id',
                    'built_date',
                    'built_place',
                    'dwt',
                    'management_in_date',
                    'management_out_date',
                    'remarks',
                    'no_of_deck_officers',
                    'no_of_engine_officers',
                    'no_of_deck_rating',
                    'no_of_engine_rating',
                    'no_of_galley_rating',
                    'created_at',
                    'updated_at',
                    'officer_nationalities',
                    'rating_nationalities',
                ]
            ]);
    }

    /** @test */
    function delete_viq_chapter()
    {
        $this->json('delete', '/api/vessels/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, Vessel::all());
    }
}
