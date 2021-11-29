<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePscInspectionDeficiencies1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('psc_inspection_deficiencies', function (Blueprint $table) {
            $table->renameColumn('evidencepath','evidencepath1');
            $table->string('evidencepath2',100)->nullable();
            $table->string('evidencepath3',100)->nullable();
            $table->string('evidencepath4',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('psc_inspection_deficiencies', function (Blueprint $table) {
            //
        });
    }
}
