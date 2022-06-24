<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlanToSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->bigInteger('property_listing_id')->after('plot_type');
            $table->integer('property_listing_plan_id')->after('property_listing_id');

            $table->foreign('property_listing_id')->references('id')->on('property_listings');
            $table->foreign('property_listing_plan_id')->references('id')->on('property_listing_plans');
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
