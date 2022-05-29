<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('surname');
            $table->string('other_names');
            $table->string('spouse_surname')->nullable();
            $table->string('spouse_names')->nullable();
            $table->string('address');
            $table->string('dob');
            $table->string('gender');
            $table->string('mar_status');
            $table->string('nationality');
            $table->string('occupation');
            $table->string('employer');
            $table->string('res_country');
            $table->string('email');
            $table->string('phone');
            $table->string('mobile')->nullable();
            $table->string('kin_name');
            $table->string('kin_phone');
            $table->string('kin_email')->nullable();
            $table->string('kin_address');
            $table->string('plot_type');
            $table->string('pay_plans');
            $table->string('no_plot');
            $table->string('plot_size');
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
        Schema::dropIfExists('subscriptions');
    }
}
