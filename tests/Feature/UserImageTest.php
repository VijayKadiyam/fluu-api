<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Site;
use App\User;
use App\UserImage;

class UserImageTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(UserImage::class)->create([
            'user_id' =>  $this->user->id
        ]);

        $this->payload = [
            'user_id'=>$this->user->id,
                'source'=>'source',
                'image_path'=>'image_path',
                'Reference_image_path'=>'Reference_image_path'
            ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/user_images', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "user_id"        =>  ["The user id field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_user_image()
    {
        $this->disableEH();
        $this->json('post', '/api/user_images', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'user_id'=>$this->user->id,
                        'source'=>'source',
                        'image_path'=>'image_path',
                        'Reference_image_path'=>'Reference_image_path'
                    ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'user_id',
                    'source',
                    'image_path',
                    'Reference_image_path',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_ofuser_images()
    {
        $this->disableEH();
        $this->json('GET', '/api/user_images?user_id='.$this->user->id.'', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'user_id',
                        'source',
                        'image_path',
                        'Reference_image_path'=>'Reference_image_path'
                    ]
                ]
            ]);
        $this->assertCount(1, UserImage::all());
    }

    /** @test */
    function show_single_user_image()
    {

        $this->json('get', "/api/user_images/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'user_id'=>$this->user->id,
                    'image_path'=>'image_path',
                    'Reference_image_path'=>'Reference_image_path',
                    'source'=>'source',
                    ]
            ]);
    }

    /** @test */
    function update_single_user_image()
    {
        $payload = [
            'user_id' =>  $this->user->id,
            'is_active' =>         true,
            'image_path' =>         'image_path',
            'Reference_image_path'=>'Reference_image_path',
            'date' =>         'date',
        ];

        $this->json('patch', '/api/user_images/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'user_id'=>$this->user->id,
                        'source'=>'source',
                        'image_path'=>'image_path',
                        'Reference_image_path'=>'Reference_image_path'
                    ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'user_id',
                    'image_path',
                    
                    'source',
                    'created_at',
                    'updated_at',
                    'Reference_image_path',
                ]
            ]);
    }

    /** @test */
    function delete_user_image()
    {
        $this->json('delete', '/api/user_images/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, UserImage::all());
    }
}
