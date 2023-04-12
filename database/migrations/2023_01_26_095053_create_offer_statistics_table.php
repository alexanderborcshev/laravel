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
        Schema::create('offer_statistics', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('new')->default(0);
            $table->integer('in_progress')->default(0);
            $table->integer('postpone')->default(0);
            $table->integer('canceled')->default(0);
            $table->integer('finished')->default(0);
            $table->bigInteger('profit')->default(0);
            $table->foreignId('offer_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_statistics');
    }
};
