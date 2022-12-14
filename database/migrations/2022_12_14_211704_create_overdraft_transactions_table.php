<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverdraftTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overdraft_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('userId')->nullable();
            $table->string('amountToSend')->nullable();
            $table->string('overdraftBalance')->nullable();
            $table->string('country')->nullable();
            $table->string('currencyCode')->nullable();
            $table->string('overdraftLimit')->nullable();
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
        Schema::dropIfExists('overdraft_transactions');
    }
}
