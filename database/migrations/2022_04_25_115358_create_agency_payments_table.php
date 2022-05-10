<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgencyPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agency_id');
            $table->unsignedBigInteger('job_id');
            $table->string('customer_id');
            $table->decimal('amount',10,2);
            $table->boolean('payment_status');
            $table->string('payment_mode')->nullable();
            $table->timestamps();


            $table->foreign('agency_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on('job_by_agencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agency_payments');
    }
}
