<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFscInspectionDeficienciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fsc_inspection_deficiencies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fsc_inspection_id')->nullable();
            $table->integer('serial_no')->nullable();
            $table->string('date_of_closure')->nullable();
            $table->string('evidencepath1')->nullable();
            $table->string('evidencepath2')->nullable();
            $table->string('evidencepath3')->nullable();
            $table->string('evidencepath4')->nullable();
            $table->string('details')->nullable();
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
        Schema::dropIfExists('fsc_inspection_deficiencies');
    }
}
