<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsExpiredToJobByAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_by_agencies', function (Blueprint $table) {
            $table->boolean('is_job_expired')->default(0)->after('is_activate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_by_agencies', function (Blueprint $table) {
            //
        });
    }
}
