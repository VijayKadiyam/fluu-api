<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLoginQuestions4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('login_questions', function (Blueprint $table) {
            $table->string('sub_description', 100)->nullable();
            $table->boolean('is_text')->default(false)->change();
            $table->boolean('is_voice')->default(false)->change();
            $table->boolean('is_video')->default(false)->change();;
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
