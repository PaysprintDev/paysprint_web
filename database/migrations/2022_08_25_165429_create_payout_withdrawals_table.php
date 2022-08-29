<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payout_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->string('ref_code')->nullable();
            $table->string('payout_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('amounttosend')->nullable();
            $table->string('country')->nullable();
            $table->string('commissiondeduct')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('payout_withdrawals');
    }
}
