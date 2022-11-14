<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerifiedMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verified_merchants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('industry')->nullable();
            $table->string('title')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('web_address')->nullable();
            $table->string('streetno')->nullable();
            $table->string('streetname')->nullable();
            $table->string('streetaddress')->nullable();
            $table->string('postalcode')->nullable();
            $table->string('character')->nullable();
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
        Schema::dropIfExists('verified_merchants');
    }
}
