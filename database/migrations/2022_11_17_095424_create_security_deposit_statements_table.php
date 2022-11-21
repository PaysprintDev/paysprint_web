<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecurityDepositStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_deposit_statements', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('reference_code')->nullable();
            $table->string('activity')->nullable();
            $table->string('credit')->nullable();
            $table->String('debit')->nullable();
            $table->string('balance')->nullable();
            $table->string('status')->nullable();
            $table->string('action')->nullable();
            $table->string('regards')->nullable();
            $table->string('statement_route')->nullable();
            $table->string('country')->nullable();
            $table->string('trans_date')->nullable();
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
        Schema::dropIfExists('security_deposit_statements');
    }
}
