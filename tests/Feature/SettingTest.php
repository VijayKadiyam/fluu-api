<?php

namespace Tests\Feature;

use App\Setting;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Site;

class SettingTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(Setting::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'banner_1_title' => 'banner_1_title',
            'banner_1_description' => 'banner_1_description',
            'banner_2_title' => 'banner_2_title',
            'banner_2_description' => 'banner_2_description',
            'banner_3_title' => 'banner_3_title',
            'banner_3_description' => 'banner_3_description',
            'audio_p_title' => 'audio_p_title',
            'audio_p_description' => 'audio_p_description',
            'current_color' => 'current_color',
            'primary_color' => 'primary_color',
            'accent_color' => 'accent_color',
            'terms_description'=>'terms_description',
            'sign_in_by_phone_description'=>'sign_in_by_phone_description',
            'otp_description'=>'otp_description',
            'gender_description'=>'gender_description',
            'gallery_page_description'=>'gallery_page_description',
            'selfie_page_description'=>'selfie_page_description',
            'video_clip_page_description'=>'video_clip_page_description',
            'questions_page_description'=>'questions_page_description',
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/settings', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "banner_1_title"        =>  ["The banner 1 title field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_setting()
    {
        $this->disableEH();
        $this->json('post', '/api/settings', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'banner_1_title' => 'banner_1_title',
                    'banner_1_description' => 'banner_1_description',
                    'banner_2_title' => 'banner_2_title',
                    'banner_2_description' => 'banner_2_description',
                    'banner_3_title' => 'banner_3_title',
                    'banner_3_description' => 'banner_3_description',
                    'audio_p_title' => 'audio_p_title',
                    'audio_p_description' => 'audio_p_description',
                    'current_color' => 'current_color',
                    'primary_color' => 'primary_color',
                    'accent_color' => 'accent_color',
                    'terms_description'=>'terms_description',
                    'sign_in_by_phone_description'=>'sign_in_by_phone_description',
                    'otp_description'=>'otp_description',
                    'gender_description'=>'gender_description',
                    'gallery_page_description'=>'gallery_page_description',
                    'selfie_page_description'=>'selfie_page_description',
                    'video_clip_page_description'=>'video_clip_page_description',
                    'questions_page_description'=>'questions_page_description',
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    // 'banner_path_1',
                    'banner_1_title',
                    'banner_1_description',
                    // 'banner_path_2',
                    'banner_2_title',
                    'banner_2_description',
                    // 'banner_path_3',
                    'banner_3_title',
                    'banner_3_description',
                    'audio_p_title',
                    'audio_p_description',
                    'current_color',
                    'primary_color',
                    'accent_color',
                    'terms_description',
                    'sign_in_by_phone_description',
                    'otp_description',
                    'gender_description',
                    'gallery_page_description',
                    'selfie_page_description',
                    'video_clip_page_description',
                    'questions_page_description',
                    'site_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_settings()
    {
        $this->disableEH();
        $this->json('GET', '/api/settings', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        // 'banner_path_1',
                        'banner_1_title',
                        'banner_1_description',
                        // 'banner_path_2',
                        'banner_2_title',
                        'banner_2_description',
                        // 'banner_path_3',
                        'banner_3_title',
                        'banner_3_description',
                    ]
                ]
            ]);
        $this->assertCount(1, Setting::all());
    }

    /** @test */
    function show_single_setting()
    {

        $this->json('get', "/api/settings/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'banner_1_title' => 'banner_1_title',
                    'banner_1_description' => 'banner_1_description',
                    'banner_2_title' => 'banner_2_title',
                    'banner_2_description' => 'banner_2_description',
                    'banner_3_title' => 'banner_3_title',
                    'banner_3_description' => 'banner_3_description',
                    'audio_p_title' => 'audio_p_title',
                    'audio_p_description' => 'audio_p_description',
                    'current_color' => 'current_color',
                    'primary_color' => 'primary_color',
                    'accent_color' => 'accent_color',
                    'terms_description'=>'terms_description',
                    'sign_in_by_phone_description'=>'sign_in_by_phone_description',
                    'otp_description'=>'otp_description',
                    'gender_description'=>'gender_description',
                    'gallery_page_description'=>'gallery_page_description',
                    'selfie_page_description'=>'selfie_page_description',
                    'video_clip_page_description'=>'video_clip_page_description',
                    'questions_page_description'=>'questions_page_description',
                ]
            ]);
    }

    /** @test */
    function update_single_setting()
    {
        $payload = [
            'banner_1_title' => 'banner_1_title',
            'banner_1_description' => 'banner_1_description',
            'banner_2_title' => 'banner_2_title',
            'banner_2_description' => 'banner_2_description',
            'banner_3_title' => 'banner_3_title',
            'banner_3_description' => 'banner_3_description',
            'audio_p_title' => 'audio_p_title',
            'audio_p_description' => 'audio_p_description',
            'current_color' => 'current_color',
            'primary_color' => 'primary_color',
            'accent_color' => 'accent_color',
            'terms_description'=>'terms_description',
            'sign_in_by_phone_description'=>'sign_in_by_phone_description',
            'otp_description'=>'otp_description',
            'gender_description'=>'gender_description',
            'gallery_page_description'=>'gallery_page_description',
            'selfie_page_description'=>'selfie_page_description',
            'video_clip_page_description'=>'video_clip_page_description',
            'questions_page_description'=>'questions_page_description',
        ];

        $this->json('patch', '/api/settings/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'banner_1_title' => 'banner_1_title',
                    'banner_1_description' => 'banner_1_description',
                    'banner_2_title' => 'banner_2_title',
                    'banner_2_description' => 'banner_2_description',
                    'banner_3_title' => 'banner_3_title',
                    'banner_3_description' => 'banner_3_description',
                    'audio_p_title' => 'audio_p_title',
                    'audio_p_description' => 'audio_p_description',
                    'current_color' => 'current_color',
                    'primary_color' => 'primary_color',
                    'accent_color' => 'accent_color',
                    'terms_description'=>'terms_description',
                    'sign_in_by_phone_description'=>'sign_in_by_phone_description',
                    'otp_description'=>'otp_description',
                    'gender_description'=>'gender_description',
                    'gallery_page_description'=>'gallery_page_description',
                    'selfie_page_description'=>'selfie_page_description',
                    'video_clip_page_description'=>'video_clip_page_description',
                    'questions_page_description'=>'questions_page_description',
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'banner_path_1',
                    'banner_1_title',
                    'banner_1_description',
                    'banner_path_2',
                    'banner_2_title',
                    'banner_2_description',
                    'banner_path_3',
                    'banner_3_title',
                    'banner_3_description',
                    'created_at',
                    'updated_at',
                    'intro_p_create_b',
                    'intro_p_already_t',
                    'intro_p_signin_b',
                    'signinbyphone_b',
                    'logo_path',
                    'terms_t',
                    'privacy_t',
                    'siginphone_p_title',
                    'siginphone_p_description',
                    'otp_p_title',
                    'gender_p_title',
                    'woman_text',
                    'man_text',
                    'other_text',
                    'gallery_p_title',
                    'gallery_p_description',
                    'selfie_p_title',
                    'selfie_p_description',
                    'audio_p_title',
                    'audio_p_description',
                    'current_color',
                    'primary_color',
                    'accent_color',
                    'terms_description',
                    'sign_in_by_phone_description',
                    'otp_description',
                    'gender_description',
                    'gallery_page_description',
                    'selfie_page_description',
                    'video_clip_page_description',
                    'questions_page_description',
                ]
            ]);
    }

    /** @test */
    function delete_setting()
    {
        $this->json('delete', '/api/settings/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, Setting::all());
    }
}
