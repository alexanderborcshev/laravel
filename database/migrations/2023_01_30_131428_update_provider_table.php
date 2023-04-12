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
        Schema::table('providers', function (Blueprint $table)
        {
            $table->string('work_time');
            $table->string('work_time_start');
            $table->string('work_time_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers', function (Blueprint $table)
        {
            $table->dropColumn([
                'work_time',
                'work_time_start',
                'work_time_end',
            ]);
        });
    }
};
