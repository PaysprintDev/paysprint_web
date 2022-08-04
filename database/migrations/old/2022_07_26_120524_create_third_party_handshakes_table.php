<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdPartyHandshakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_party_handshakes', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('telephone')->default('NULL');
            $table->string('country');
            $table->string('platform')->default('NULL');
            $table->string('invited_userId')->default('NULL');
            $table->string('national_id_card')->default('NULL');
            $table->string('drivers_license')->default('NULL');
            $table->string('international_passport')->default('NULL');
            $table->string('utility_bill')->default('NULL');
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
        Schema::dropIfExists('third_party_handshakes');
    }
}
