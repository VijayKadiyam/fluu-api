<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePscInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psc_inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->integer('vessel_id')->nullable();
            $table->string('date')->nullable();
            $table->integer('port_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('deficiency_id')->nullable();
            $table->boolean('is_detained')->default(0);
            $table->string('reportpath')->nullable();
            $table->boolean('is_deficiency_closed')->default();
            $table->string('date_of_closure')->nullable();
            $table->string('evidencepath')->nullable();
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
        Schema::dropIfExists('psc_inspections');
    }
}
