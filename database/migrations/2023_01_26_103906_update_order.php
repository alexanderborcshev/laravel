<?php

use App\Models\Enums\OrderStatusEnum;
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
        Schema::table('orders', function (Blueprint $table)
        {
            $table->string('status')->default(OrderStatusEnum::new->name);
            $table->boolean('accepted')->default(0);
            $table->unsignedInteger('price')->default(0);
            $table->string('postpone')->default('');
            $table->boolean('verified')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table)
        {
            $table->dropColumn([
                'status',
                'accepted',
            ]);
        });
    }
};
