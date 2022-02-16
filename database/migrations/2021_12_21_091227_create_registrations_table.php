<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->date('dob')->nullable();
            $table->string('ssn')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('profile_image')->nullable();
            $table->text('bio')->nullable();
            $table->integer('experience')->nullable();
            $table->string('work_type')->nullable();
            $table->integer('total_care_completed')->nullable();
            $table->integer('total_reviews')->nullable();
            $table->integer('rating')->nullable();
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('registrations');
    }
}
