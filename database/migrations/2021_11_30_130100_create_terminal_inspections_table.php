<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminalInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminal_inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->nullable();
            $table->integer('vessel_id')->nullable();
            $table->string('date')->nullable();
            $table->integer('port_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('no_of_closed_deficiencies')->nullable();
            $table->string('reportpath')->nullable();
            $table->boolean('is_deficiency_closed')->nullable();
            $table->string('date_of_closure')->nullable();
            $table->string('evidencepath')->nullable();
            $table->longText('additional_comments')->nullable();
            $table->integer('no_of_issued_deficiencies')->nullable();
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
        Schema::dropIfExists('terminal_inspections');
    }
}
