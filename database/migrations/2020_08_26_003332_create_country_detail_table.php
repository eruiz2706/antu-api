<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_detail', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('capital_city');
            $table->string('phone_code');
            $table->string('continent_code');
            $table->string('currency_code');
            $table->string('flag');
            $table->json('languaje');
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
        Schema::dropIfExists('country_detail');
    }
}
