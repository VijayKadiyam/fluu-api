<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 100)->nullable();
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('user_name', 100)->nullable();
            $table->string('gender')->nullable();
            $table->string('dob', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('api_token', 60)->unique()->nullable();
            $table->integer('active')->default(0);
            $table->string('password');
            $table->string('gallery_image_path', 100)->nullable();
            $table->string('selfie_image_path', 100)->nullable();
            $table->string('voice_clip_path', 100)->nullable();
            $table->integer('zodiac_sign_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
