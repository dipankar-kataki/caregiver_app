<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobByAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_by_agencies', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->string('care_type');
            $table->integer('patient_age');
            $table->string('amount_per_hour');
            $table->date('start_date_of_care');
            $table->date('end_date_of_care');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->integer('zip_code');
            $table->text('job_description');
            $table->text('medical_history');
            $table->text('essential_prior_expertise');
            $table->text('other_requirements');
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_activate')->default(1);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_by_agencies');
    }
}
