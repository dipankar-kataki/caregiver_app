<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCaregiverChargeToAgencyPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agency_payments', function (Blueprint $table) {
            $table->decimal('caregiver_charge', 10,2)->after('customer_id');
            $table->decimal('peaceworc_charge', 10,2)->after('caregiver_charge');
            $table->integer('peaceworc_percentage')->after('peaceworc_charge');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agency_payments', function (Blueprint $table) {
            //
        });
    }
}
