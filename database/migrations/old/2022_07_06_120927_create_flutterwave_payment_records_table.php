<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlutterwavePaymentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flutterwave_payment_records', function (Blueprint $table) {
            $table->id();
            $table->integer('userId');
            $table->integer('recordId');
            $table->string('tx_ref');
            $table->string('flw_ref');
            $table->string('amount');
            $table->string('currency');
            $table->string('charged_amount');
            $table->string('app_fee');
            $table->string('merchant_fee');
            $table->string('processor_response');
            $table->string('auth_model');
            $table->string('narration');
            $table->string('status');
            $table->string('payment_type');
            $table->string('amount_settled');
            $table->string('customer');
            $table->integer('account_id');
            $table->string('meta');
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
        Schema::dropIfExists('flutterwave_payment_records');
    }
}