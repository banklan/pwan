<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLandmarkToPropertiesListing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_listings', function (Blueprint $table) {
            $table->string('landmark')->after('location')->nullable();
            $table->string('type')->after('landmark')->nullable();
            $table->boolean('availability')->default(true)->after('type');
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
