<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDusupaymentReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dusupayment_references', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('dusu_id');
            $table->string('request_amount');
            $table->string('request_currency');
            $table->string('account_amount');
            $table->string('account_currency');
            $table->string('transaction_fee');
            $table->string('total_debit');
            $table->string('provider_id');
            $table->string('paysprint_reference');
            $table->string('Dusupay_reference');
            $table->string('transaction_status');
            $table->string('transaction_type');
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
        Schema::dropIfExists('dusupayment_references');
    }
}
