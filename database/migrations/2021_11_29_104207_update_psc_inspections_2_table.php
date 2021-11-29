<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePscInspections2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('psc_inspections', function (Blueprint $table) {
            $table->integer('no_of_issued_deficiencies')->default(0)->before('no_of_deficiencies');
        });
        Schema::table('psc_inspections', function (Blueprint $table) {
            $table->renameColumn('no_of_deficiencies', 'no_of_closed_deficiencies')->default(0);
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
