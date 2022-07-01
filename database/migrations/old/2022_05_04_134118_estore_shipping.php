<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EstoreShipping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estore_shipping', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchantId');
            $table->string('country');
            $table->string('state');
            $table->string('currencyCode');
            $table->integer('deliveryRate')->default(0);
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
        Schema::dropIfExists('estore_shipping');
    }
}