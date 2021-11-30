<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use phpDocumentor\Reflection\PseudoTypes\False_;

class CreateFscInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fsc_inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->nullable();
            $table->integer('vessel_id')->nullable();
            $table->string('date',100)->nullable();
            $table->string('port_id',100)->nullable();
            $table->string('country_id',100)->nullable();
            $table->string('no_of_issued_deficiencies',100)->nullable();
            $table->string('no_of_closed_deficiencies',100)->nullable();
            $table->boolean('is_detained')->default(FALSE);
            $table->boolean('is_deficiency_closed')->default(FALSE);
            $table->string('reportpath',100)->nullable();
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
        Schema::dropIfExists('fsc_inspections');
    }
}
