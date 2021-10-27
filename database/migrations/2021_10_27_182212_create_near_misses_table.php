<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNearMissesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('near_misses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->integer('number_reported')->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('activity_id')->nullable();
            $table->integer('basic_cause_id')->nullable();
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
        Schema::dropIfExists('near_misses');
    }
}
