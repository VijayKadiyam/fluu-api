<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSireInspectionDetails2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sire_inspection_details', function (Blueprint $table) {
            $table->string('date_of_closure')->nullable();
            $table->string('evidence')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('is_closed')->default(false);
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
