<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSireInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sire_inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->integer('vessel_id')->nullable();
            $table->string('inspection_type')->nullable();
            $table->string('inspection_type_detail')->nullable();
            $table->integer('oil_major_id')->nullable();
            $table->string('date_of_inspection')->nullable();
            $table->integer('inspector_id')->nullable();
            $table->string('total_observations')->nullable();
            $table->string('attachment')->nullable();
            $table->integer('port_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('sire_inspections');
    }
}
