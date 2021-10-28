<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVesselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vessels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->string('serial_no')->nullable();
            $table->string('name')->nullable();
            $table->integer('imo_no')->nullable();
            $table->integer('vessel_type_id')->nullable();
            $table->string('built_date')->nullable();
            $table->string('built_place')->nullable();
            $table->string('dwt')->nullable();
            $table->string('management_in_date')->nullable();
            $table->string('management_out_date')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('no_of_deck_officers')->nullable();
            $table->integer('no_of_engine_officers')->nullable();
            $table->integer('no_of_deck_rating')->nullable();
            $table->integer('no_of_engine_rating')->nullable();
            $table->integer('no_of_galley_rating')->nullable();
            $table->integer('officer_nationalities')->nullable();
            $table->integer('rating_nationalities')->nullable();
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
        Schema::dropIfExists('vessels');
    }
}
