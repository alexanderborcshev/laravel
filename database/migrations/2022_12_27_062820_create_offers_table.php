<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('orders_count');
            $table->bigInteger('price_min');
            $table->bigInteger('price_max');
            $table->unsignedBigInteger('provider_id');
            $table->longText('main_text');
            $table->string('main_text_title');
            $table->longText('description');
            $table->json('prices');
            $table->json('gifts');
            $table->unsignedBigInteger('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
