<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceStoreTestimoniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_store_testimonies', function (Blueprint $table) {
            $table->id();
            $table->string('merchantId');
            $table->string('value')->nullable();
            $table->string('testimonialName')->nullable();
            $table->string('testimonialImage')->nullable();
            $table->string('testimonialRating')->nullable();
            $table->longText('testimonialDescription')->nullable();
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
        Schema::dropIfExists('service_store_testimonies');
    }
}
