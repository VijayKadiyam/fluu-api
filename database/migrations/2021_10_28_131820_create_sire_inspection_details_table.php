<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSireInspectionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sire_inspection_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sire_inspection_id');
            $table->integer('viq_chapter_id')->nullable();
            $table->integer('serial_no')->nullable();
            $table->longText('details')->nullable();
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
        Schema::dropIfExists('sire_inspection_details');
    }
}
