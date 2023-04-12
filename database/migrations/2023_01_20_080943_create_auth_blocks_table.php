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
        Schema::create('auth_blocks', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip');
            $table->dateTime('date_sms')->nullable();
            $table->dateTime('date_login')->nullable();
            $table->integer('count_sms')->default(0);
            $table->integer('count_login')->default(0);
            $table->string('login')->default(0);
            $table->boolean('permanent')->default(0);
            $table->index(['ip']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_blocks');
    }
};
