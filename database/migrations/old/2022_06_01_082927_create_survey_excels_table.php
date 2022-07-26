<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyExcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_excels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date');
            $table->string('email');
            $table->string('Question_1');
            $table->string('Question_2');
            $table->string('Question_3');
            $table->string('Question_4');
            $table->string('Question_5');
            $table->string('Question_6');
            $table->string('Question_7');
            $table->string('Question_8');
            $table->string('Question_9');
            $table->string('Question_10');
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
        Schema::dropIfExists('survey_excels');
    }
}
