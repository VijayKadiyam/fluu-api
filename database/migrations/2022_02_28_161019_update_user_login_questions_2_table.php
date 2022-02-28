<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserLoginQuestions2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_login_questions', function (Blueprint $table) {
            $table->dropColumn('Image_option_1');
           
        });
        Schema::table('user_login_questions', function (Blueprint $table) {
          
           $table->dropColumn('Image_option_2');
         
        });
        Schema::table('user_login_questions', function (Blueprint $table) {
           
           $table->dropColumn('Image_option_3');
         
        });
        Schema::table('user_login_questions', function (Blueprint $table) {
          
           $table->dropColumn('Image_option_4');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_login_questions', function (Blueprint $table) {
            //
        });
    }
}
