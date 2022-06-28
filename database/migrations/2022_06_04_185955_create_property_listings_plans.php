<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyListingsPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_listing_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('property_listing_id')->unsigned();
            $table->string('unit')->nullable();
            $table->string('name');
            $table->bigInteger('price')->unsigned();
            $table->timestamps();

            $table->foreign('property_listing_id')->references('id')->on('property_listing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_listing_plans');
    }
}
