<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSettings1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('intro_p_create_b', 100)->nullable();
            $table->string('intro_p_already_t', 100)->nullable();
            $table->string('intro_p_signin_b', 100)->nullable();
            $table->string('signinbyphone_b', 100)->nullable();
            $table->string('logo_path', 100)->nullable();
            $table->string('terms_t', 100)->nullable();
            $table->string('privacy_t', 100)->nullable();
            $table->string('siginphone_p_title', 100)->nullable();
            $table->string('siginphone_p_description', 100)->nullable();
            $table->string('otp_p_title', 100)->nullable();
            $table->string('gender_p_title', 100)->nullable();
            $table->string('woman_text', 100)->nullable();
            $table->string('man_text', 100)->nullable();
            $table->string('other_text', 100)->nullable();
            $table->string('gallery_p_title', 100)->nullable();
            $table->string('gallery_p_description', 100)->nullable();
            $table->string('selfie_p_title', 100)->nullable();
            $table->string('selfie_p_description', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
