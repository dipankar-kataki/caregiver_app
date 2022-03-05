<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAuthorizedOfficerBelongsToAuthorizedOfficersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('authorized_officers', function (Blueprint $table) {
            $table->integer('officer_belongs_to_user')->after('zip_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authorized_officers', function (Blueprint $table) {
            //
        });
    }
}
