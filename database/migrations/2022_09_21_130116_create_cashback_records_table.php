<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashbackRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashback_records', function (Blueprint $table) {
            $table->id();
            $table->integer('merchant_id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->string('user_cashback_amount');
            $table->string('merchant_cashback_amount');
            $table->string('paysprint_cashback');
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
        Schema::dropIfExists('cashback_records');
    }
}
