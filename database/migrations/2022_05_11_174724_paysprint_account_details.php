<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaysprintAccountDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paysprint_account_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_number')->default('TO-11052022-6047');
            $table->string('account_name')->default('PaySprint Inc.');
            $table->string('account_number')->default('21205247594');
            $table->string('bank_name')->default('TD CANADA TRUST');
            $table->string('swift_code')->default('TDOMCATTTOR');
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
        Schema::dropIfExists('paysprint_account_details');
    }
}
