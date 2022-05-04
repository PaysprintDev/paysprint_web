<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EstoreDelivery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estore_delivery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchantId');
            $table->integer('userId');
            $table->string('orderId');
            $table->integer('productId');
            $table->string('deliveryCode');
            $table->string('status')->default('not claimed');
            $table->string('expiry');
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
        Schema::dropIfExists('estore_delivery');
    }
}
