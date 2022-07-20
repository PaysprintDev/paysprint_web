<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceMainStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_main_stores', function (Blueprint $table) {
            $table->id();
            $table->string('merchantId');
            $table->string('value')->nullable();
            $table->string('businessLogo')->nullable();
            $table->string('backdropImage')->nullable();
            $table->string('businessWelcome')->nullable();
            $table->string('businessWhatWeAre')->nullable();
            $table->string('businessSlogan')->nullable();
            $table->string('youtubeLink')->nullable();
            $table->string('website')->nullable();
            $table->longText('aboutUs')->nullable();
            $table->string('aboutUsQ1')->nullable();
            $table->longText('aboutUsA1')->nullable();
            $table->string('aboutUsQ2')->nullable();
            $table->longText('aboutUsA2')->nullable();
            $table->string('aboutUsQ3')->nullable();
            $table->longText('aboutUsA3')->nullable();
            $table->string('aboutImportantImage')->nullable();
            $table->string('services1')->nullable();
            $table->longText('serviceBenefits1')->nullable();
            $table->string('services2')->nullable();
            $table->longText('serviceBenefits2')->nullable();
            $table->string('services3')->nullable();
            $table->longText('serviceBenefits3')->nullable();
            $table->string('services4')->nullable();
            $table->longText('serviceBenefits4')->nullable();
            $table->string('services5')->nullable();
            $table->longText('serviceBenefits5')->nullable();
            $table->string('services6')->nullable();
            $table->longText('serviceBenefits6')->nullable();
            $table->string('pricing1')->nullable();
            $table->string('pricingPlan1')->nullable();
            $table->longText('pricingOffer1')->nullable();
            $table->string('pricing2')->nullable();
            $table->string('pricingPlan2')->nullable();
            $table->longText('pricingOffer2')->nullable();
            $table->string('pricing3')->nullable();
            $table->string('pricingPlan3')->nullable();
            $table->longText('pricingOffer3')->nullable();
            $table->string('contactNumber')->nullable();
            $table->string('contactEmail')->nullable();
            $table->boolean('publish')->default(false);
            $table->string('status')->default('not active');
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
        Schema::dropIfExists('service_main_stores');
    }
}
