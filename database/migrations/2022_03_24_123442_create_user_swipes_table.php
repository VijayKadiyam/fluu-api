<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSwipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_swipes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('no_of_swipes', 100)->nullable();
            $table->string('date', 100)->nullable();
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
        Schema::dropIfExists('user_swipes');
    }
}
