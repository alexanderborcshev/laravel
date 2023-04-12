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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('status');
            $table->foreignId('provider_id');
            $table->foreignId('accountant_id');
            $table->foreignId('accept_user_id');
            $table->integer('sum')->default(0);
            $table->integer('number');
            $table->foreignId('file_act_id');
            $table->foreignId('file_report_id');
            $table->foreignId('file_bill_id');
            $table->boolean('auto_accept')->default(0);
            $table->boolean('send')->default(0);
            $table->dateTime('accept_date')->nullable();
            $table->dateTime('used_date')->nullable();
            $table->integer('profit')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
};
