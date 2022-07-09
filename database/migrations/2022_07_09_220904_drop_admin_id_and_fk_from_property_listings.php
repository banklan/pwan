<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAdminIdAndFkFromPropertyListings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_listings', function (Blueprint $table) {
            $table->dropColumn('admin_id');
            $table->dropForeign(['admin_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_listings', function (Blueprint $table) {
            //
        });
    }
}
