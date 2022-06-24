<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->boolean('is_approved')->default(0);
            $table->boolean('is_active')->default(1);
            $table->string('flier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_offers');
    }
}
