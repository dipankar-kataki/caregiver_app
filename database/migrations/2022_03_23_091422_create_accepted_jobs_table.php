<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcceptedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accepted_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_by_agencies_id');
            $table->integer('caregiver_id');
            $table->integer('agency_id');
            $table->timestamps();

            $table->foreign('job_by_agencies_id')->references('id')->on('job_by_agencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accepted_jobs');
    }
}
