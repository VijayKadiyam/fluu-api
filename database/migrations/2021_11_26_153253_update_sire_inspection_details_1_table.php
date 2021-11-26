<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSireInspectionDetails1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sire_inspection_details', function (Blueprint $table) {
            $table->renameColumn('serial_no', 'viq_no');
        });
        Schema::table('sire_inspection_details', function (Blueprint $table) {
            $table->renameColumn('details', 'observation');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sire_inspection_details', function (Blueprint $table) {
            //
        });
    }
}
