<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->string('description', 100)->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_mcq')->default(1);
            $table->string('option_1', 100)->nullable();
            $table->string('option_2', 100)->nullable();
            $table->string('option_3', 100)->nullable();
            $table->string('option_4', 100)->nullable();
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
        Schema::integer('login_questions');
    }
}
