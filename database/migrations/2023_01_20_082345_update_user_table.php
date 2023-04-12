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
        Schema::table('users', function (Blueprint $table)
        {
            $table->text('second_name')->after('name')->nullable();
            $table->text('last_name')->after('second_name')->nullable();
            $table->text('phone')->nullable();
            $table->string('login')->nullable()->unique();
            $table->text('post')->nullable();
            $table->text('sms_hash')->nullable();
            $table->text('google_id')->nullable();
            $table->boolean('blocked')->nullable();
            $table->dateTime('blocked_date')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table)
        {
            $table->dropColumn([
                'second_name',
                'last_name',
                'phone',
                'login',
                'post',
                'sms_hash',
                'google_id',
                'blocked',
                'blocked_date',
            ]);
        });
    }
};
