<?php

namespace Tests\Feature;

use App\Site;
use App\ViqChapter;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViqChapterTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(ViqChapter::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'serial_no'  =>  1,
            'chapter_name'  =>  'Chapter Name',
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/viq_chapters', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "serial_no"        =>  ["The serial no field is required."],
                    "chapter_name"        =>  ["The chapter name field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_viq_chapter()
    {
        $this->disableEH();
        $this->json('post', '/api/viq_chapters', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'serial_no'  =>  1,
                    'chapter_name'  =>  'Chapter Name',
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'serial_no',
                    'chapter_name',
                    'site_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_viq_chapters()
    {
        $this->disableEH();
        $this->json('GET', '/api/viq_chapters', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'serial_no',
                        'chapter_name'
                    ]
                ]
            ]);
        $this->assertCount(1, ViqChapter::all());
    }

    /** @test */
    function show_single_viq_chapter()
    {

        $this->json('get', "/api/viq_chapters/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'serial_no'  =>  1,
                    'chapter_name'  =>  'Chapter Name',
                ]
            ]);
    }

    /** @test */
    function update_single_viq_chapter()
    {
        $payload = [
            'serial_no'  =>  2,
            'chapter_name'  =>  'Chapter Name Updated',
        ];

        $this->json('patch', '/api/viq_chapters/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'serial_no'  =>  2,
                    'chapter_name'  =>  'Chapter Name Updated',
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'serial_no',
                    'chapter_name',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /** @test */
    function delete_viq_chapter()
    {
        $this->json('delete', '/api/viq_chapters/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, ViqChapter::all());
    }
}
