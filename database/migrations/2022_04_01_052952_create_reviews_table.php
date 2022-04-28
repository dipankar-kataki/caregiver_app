<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_by');
            $table->string('role');
            $table->decimal('rating',2,1);
            $table->string('content');
            $table->unsignedBigInteger('review_to');
            $table->timestamps();

            $table->foreign('review_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('review_to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
