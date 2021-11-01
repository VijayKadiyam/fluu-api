<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePscInspections1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('psc_inspections', function (Blueprint $table) {
            $table->renameColumn('deficiency_id', 'no_of_deficiencies');
        });
        Schema::table('psc_inspections', function (Blueprint $table) {
            $table->integer("no_of_deficiencies")->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('psc_inspections', function (Blueprint $table) {
            //
        });
    }
}
