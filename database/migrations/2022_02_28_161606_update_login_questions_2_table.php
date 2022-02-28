<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLoginQuestions2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('login_questions', function (Blueprint $table) {
            $table->string('description_image_1', 100)->nullable();
            $table->string('image_option_1', 100)->nullable();
            $table->string('image_option_2', 100)->nullable();
            $table->string('image_option_3', 100)->nullable();
            $table->string('image_option_4', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('login_questions', function (Blueprint $table) {
            //
        });
    }
}
