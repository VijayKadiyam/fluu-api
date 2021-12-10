<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInternalAuditDeficiencies1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal_audit_deficiencies', function (Blueprint $table) {
            $table->renameColumn('date_of_closure', 'issued_date');
            $table->integer('reference_no')->default(0);
            $table->string('verification_date',100)->nullable();
        });

        Schema::table('internal_audit_deficiencies', function (Blueprint $table) {
            $table->renameColumn('evidencepath1', 'deficiency_nature');
        });

        Schema::table('internal_audit_deficiencies', function (Blueprint $table) {
            $table->renameColumn('evidencepath2', 'target_date');
        });

        Schema::table('internal_audit_deficiencies', function (Blueprint $table) {
            $table->renameColumn('evidencepath3', 'completion_date');
        });

        Schema::table('internal_audit_deficiencies', function (Blueprint $table) {
            $table->renameColumn('evidencepath4', 'evidencepath');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internal_audit_deficiencies', function (Blueprint $table) {
            //
        });
    }
}
