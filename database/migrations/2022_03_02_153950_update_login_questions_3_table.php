<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLoginQuestions3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('login_questions', function (Blueprint $table) {
            $table->boolean('is_text')->default(true);
            $table->boolean('is_voice')->default(true);
            $table->boolean('is_video')->default(true);
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
