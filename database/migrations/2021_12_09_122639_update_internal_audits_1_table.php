<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInternalAudits1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal_audits', function (Blueprint $table) {
            $table->renameColumn('complition_date', 'completion_date');

        });

        Schema::table('internal_audits', function (Blueprint $table) {
            $table->renameColumn('no_of_closed_deficiencies', 'audit_type_id');
        });

        Schema::table('internal_audits', function (Blueprint $table) {
            $table->renameColumn('is_deficiency_closed', 'other_audit_type');
        });
        Schema::table('internal_audits', function (Blueprint $table) {
            $table->string('other_audit_type',100)->nullable()->change();
            $table->string('from', 100)->nullable();
            $table->string('to', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internal_audits', function (Blueprint $table) {
            //
        });
    }
}
