<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBioToBusinessInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_information', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('id');
            $table->text('beneficiary')->nullable()->after('annual_business_revenue');
            $table->text('homecare_service')->nullable()->after('beneficiary');
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
