<?php

namespace Tests\Feature;

use App\LoginQuestion;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Site;

class LoginQuestionTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(LoginQuestion::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'description' => 'description',
            'is_active' => true,
            'is_mcq' => true,
            'option_1' => 'option_1',
            'option_2' => 'option_2',
            'option_3' => 'option_3',
            'option_4' => 'option_4',
            'description_image_1'=>'description_image_1',
            'image_option_1'=>'image_option_1',
            'image_option_2'=>'image_option_2',
            'image_option_3'=>'image_option_3',
            'image_option_4'=>'image_option_4',
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/login_questions', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "description"        =>  ["The description field is required."],
                    "is_active"        =>  ["The is active field is required."],
                    "is_mcq"        =>  ["The is mcq field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_login_question()
    {
        $this->disableEH();
        $this->json('post', '/api/login_questions', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'description' => 'description',
                    'is_active' => true,
                    'is_mcq' => true,
                    'option_1' => 'option_1',
                    'option_2' => 'option_2',
                    'option_3' => 'option_3',
                    'option_4' => 'option_4',
                    'description_image_1'=>'description_image_1',
                    'image_option_1'=>'image_option_1',
                    'image_option_2'=>'image_option_2',
                    'image_option_3'=>'image_option_3',
                    'image_option_4'=>'image_option_4',
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'description',
                    'is_active',
                    'is_mcq',
                    'option_1',
                    'option_2',
                    'option_3',
                    'option_4',
                    'description_image_1',
                    'image_option_1',
                    'image_option_2',
                    'image_option_3',
                    'image_option_4',
                    'site_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_login_questions()
    {
        $this->disableEH();
        $this->json('GET', '/api/login_questions', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'description',
                        'is_active',
                        'is_mcq',
                        'option_1',
                        'option_2',
                        'option_3',
                        'option_4',
                        'description_image_1',
                        'image_option_1',
                        'image_option_2',
                        'image_option_3',
                        'image_option_4',
                    ]
                ]
            ]);
        $this->assertCount(1, LoginQuestion::all());
    }

    /** @test */
    function show_single_login_question()
    {

        $this->json('get', "/api/login_questions/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'description' => 'description',
                    'is_active' => true,
                    'is_mcq' => true,
                    'option_1' => 'option_1',
                    'option_2' => 'option_2',
                    'option_3' => 'option_3',
                    'option_4' => 'option_4',
                    'description_image_1'=>'description_image_1',
                    'image_option_1'=>'image_option_1',
                    'image_option_2'=>'image_option_2',
                    'image_option_3'=>'image_option_3',
                    'image_option_4'=>'image_option_4',
                ]
            ]);
    }

    /** @test */
    function update_single_login_question()
    {
        $payload = [
            'description' => 'description',
            'is_active' => true,
            'is_mcq' => true,
            'option_1' => 'option_1',
            'option_2' => 'option_2',
            'option_3' => 'option_3',
            'option_4' => 'option_4',
            'description_image_1'=>'description_image_1',
            'image_option_1'=>'image_option_1',
            'image_option_2'=>'image_option_2',
            'image_option_3'=>'image_option_3',
            'image_option_4'=>'image_option_4',
        ];

        $this->json('patch', '/api/login_questions/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'description' => 'description',
                    'is_active' => true,
                    'is_mcq' => true,
                    'option_1' => 'option_1',
                    'option_2' => 'option_2',
                    'option_3' => 'option_3',
                    'option_4' => 'option_4',
                    'description_image_1'=>'description_image_1',
                    'image_option_1'=>'image_option_1',
                    'image_option_2'=>'image_option_2',
                    'image_option_3'=>'image_option_3',
                    'image_option_4'=>'image_option_4',
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'description',
                    'is_active',
                    'is_mcq',
                    'option_1',
                    'option_2',
                    'option_3',
                    'option_4',  
                    'created_at',
                    'updated_at',
                    'description_image_1',
                    'image_option_1',
                    'image_option_2',
                    'image_option_3',
                    'image_option_4',
                ]
            ]);
    }

    /** @test */
    function delete_login_question()
    {
        $this->json('delete', '/api/login_questions/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, LoginQuestion::all());
    }
}
