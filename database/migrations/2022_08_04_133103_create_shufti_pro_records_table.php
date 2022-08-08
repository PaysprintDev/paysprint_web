<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShuftiProRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shufti_pro_records', function (Blueprint $table) {
            $table->id();
            $table->string('userId');
            $table->string('reference');
            $table->string('event');
            $table->string('email');
            $table->string('country');
            $table->longText('verification_data');
            $table->longText('verification_result');
            $table->longText('info');
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
        Schema::dropIfExists('shufti_pro_records');
    }
}
