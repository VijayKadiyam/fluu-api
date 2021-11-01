<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePscInspectionDeficienciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psc_inspection_deficiencies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('psc_inspection_id')->nullable();
            $table->integer('serial_no')->nullable();
            $table->string('date_of_closure')->nullable();
            $table->string('evidencepath')->nullable();
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
        Schema::dropIfExists('psc_inspection_deficiencies');
    }
}
