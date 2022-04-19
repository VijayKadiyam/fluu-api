<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSettings3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('terms_description', 100)->nullable();
            $table->string('sign_in_by_phone_description', 100)->nullable();
            $table->string('otp_description', 100)->nullable();
            $table->string('gender_description', 100)->nullable();
            $table->string('gallery_page_description', 100)->nullable();
            $table->string('selfie_page_description', 100)->nullable();
            $table->string('video_clip_page_description', 100)->nullable();
            $table->string('questions_page_description', 100)->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
