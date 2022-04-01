<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTotalRatingToBusinessInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_information', function (Blueprint $table) {
            $table->integer('total_reviews')->after('homecare_service')->nullable();
            $table->decimal('rating',2,1)->after('total_reviews')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_information', function (Blueprint $table) {
            //
        });
    }
}
