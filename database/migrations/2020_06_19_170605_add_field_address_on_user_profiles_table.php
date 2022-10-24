<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldAddressOnUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string("address")->nullable();
            $table->string("number")->nullable();
            $table->string("neighborhood")->nullable();
            $table->string("postalcode")->nullable();
            $table->string("state")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn("address");
            $table->dropColumn("number");
            $table->dropColumn("neighborhood");
            $table->dropColumn("postalcode");
            $table->dropColumn("state");
        });
    }
}
