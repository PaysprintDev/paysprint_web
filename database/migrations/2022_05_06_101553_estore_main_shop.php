<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EstoreMainShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('estore_main_shop', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchantId');
            $table->string('businessLogo');
            $table->string('headerContent');
            $table->string('headerTitle');
            $table->string('headerSubtitle');
            $table->string('advertSectionImage')->default('NULL');
            $table->string('advertTitle')->default('NULL');
            $table->string('advertSubtitle')->default('NULL');
            $table->string('refundPolicy');
            $table->tinyInteger('publish')->default(false);
            $table->string('status')->default('not active');
            $table->string('whatsapp')->default('NULL');
            $table->string('facebook')->default('NULL');
            $table->string('instagram')->default('NULL');
            $table->string('twitter')->default('NULL');
            $table->softDeletes();
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
        //
    }
}
