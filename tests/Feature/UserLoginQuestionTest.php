<?php

namespace Tests\Feature;

use App\LoginQuestion;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Site;
use App\UserLoginQuestion;

class UserLoginQuestionTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        $this->loginQuestion = factory(LoginQuestion::class)->create([
            'site_id' =>  $this->site->id
        ]);

        factory(UserLoginQuestion::class)->create([
            'login_question_id' =>  $this->loginQuestion->id
        ]);

        $this->payload = [
            'login_question_id' => $this->loginQuestion->id,
            'user_id' =>         1,
            'answer' =>         'answer',
            'selected_option' =>         1,
           
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/user_login_questions', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "login_question_id"        =>  ["The login question id field is required."],
                    "user_id"        =>  ["The user id field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_user_login_question()
    {
        $this->disableEH();
        $this->json('post', '/api/user_login_questions', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'login_question_id' => $this->loginQuestion->id,
                    'user_id' =>         1,
                    'answer' =>         'answer',
                    'selected_option' =>         1,
                   
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'login_question_id',
                    'user_id',
                    'answer',
                    'selected_option',    
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_user_login_questions()
    {
        $this->disableEH();
        $this->json('GET', '/api/user_login_questions?user_id=1', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'login_question_id',
                        'user_id',
                        'answer',
                        'selected_option',
                      
                    ]
                ]
            ]);
        $this->assertCount(1, UserLoginQuestion::all());
    }

    /** @test */
    function show_single_user_login_question()
    {

        $this->json('get', "/api/user_login_questions/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'login_question_id' => $this->loginQuestion->id,
                    'user_id' =>         1,
                    'answer' =>         'answer',
                    'selected_option' =>         1,
                   
                    
                ]
            ]);
    }

    /** @test */
    function update_single_user_login_question()
    {
        $payload = [
            'login_question_id' => $this->loginQuestion->id,
            'user_id' =>         1,
            'answer' =>         'answer',
            'selected_option' =>         1,
            
        ];

        $this->json('patch', '/api/user_login_questions/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'login_question_id' => $this->loginQuestion->id,
                    'user_id' =>         1,
                    'answer' =>         'answer',
                    'selected_option' =>         1,
                    
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'login_question_id',
                    'user_id',
                    'answer',
                    'selected_option',
                    'created_at',
                    'updated_at',
                  
                ]
            ]);
    }

    /** @test */
    function delete_user_login_question()
    {
        $this->json('delete', '/api/user_login_questions/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, UserLoginQuestion::all());
    }
}
