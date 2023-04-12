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
        Schema::table('managers', function (Blueprint $table)
        {
            $table->boolean('owner')->default(0);
            $table->boolean('first')->default(0);
            $table->boolean('rule')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('managers', function (Blueprint $table)
        {
            $table->dropColumn([
                'owner',
                'first',
                'rule',
            ]);
        });
    }
};
