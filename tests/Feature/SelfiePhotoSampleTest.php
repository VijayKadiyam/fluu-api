<?php

namespace Tests\Feature;

use App\SelfiePhotoSample;
use App\Site;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SelfiePhotoSampleTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(SelfiePhotoSample::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'title'  => 'title',
            'image_path' => 'image_path',
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/selfie_photo_samples', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "title"        =>  ["The title field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_selfie_photo_samples()
    {
        $this->disableEH();
        $this->json('post', '/api/selfie_photo_samples', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'title'  => 'title',
                    'image_path' => 'image_path',
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'title',
                    'image_path',
                    'site_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_selfie_photo_samples()
    {
        $this->disableEH();
        $this->json('GET', '/api/selfie_photo_samples', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'title',
                        'image_path',
                    ]
                ]
            ]);
        $this->assertCount(1, SelfiePhotoSample::all());
    }

    /** @test */
    function show_single_selfie_photo_samples()
    {

        $this->json('get', "/api/selfie_photo_samples/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'title'  => 'title',
                    'image_path' => 'image_path',
                ]
            ]);
    }

    /** @test */
    // function update_single_selfie_photo_samples()
    // {
    //     $payload = [
    //         'title'  => 'title',
    //         'image_path' =>  'image_path',
    //     ];

    //     $this->json('patch', '/api/selfie_photo_samples/1', $payload, $this->headers)
    //         ->assertStatus(200)
    //         ->assertJson([
    //             'data'    => [
    //                 'title'  => 'title',
    //                 'image_path' =>  'image_path',
    //             ]
    //         ])
    //         ->assertJsonStructureExact([
    //             'data'  => [
    //                 'id',
    //                 'site_id',
    //                 'title',
    //                 'image_path',
    //                 'created_at',
    //                 'updated_at',
    //             ]
    //         ]);
    // }

    function update_single_login_question()
    {
        $payload = [
            'title' => 'title',
            'image_path' => 'image_path',
        ];

        $this->json('patch', '/api/selfie_photo_samples/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'title' => 'title',
                    'image_path' => 'image_path',
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'title',
                    'image_path',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
    /** @test */
    function delete_selfie_photo_samples()
    {
        $this->json('delete', '/api/selfie_photo_samples/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, SelfiePhotoSample::all());
    }
}
