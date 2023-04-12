<?php

use App\Models\Enums\OfferStatusEnum;
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
        Schema::table('offers', function (Blueprint $table)
        {
            $table->foreignId('manager_id');
            $table->string('status')->default(OfferStatusEnum::new->name);
            $table->smallInteger('commission')->default(0);
            $table->integer('number')->default(0);
            $table->json('text_sections');
            $table->text('pause_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table)
        {
            $table->dropColumn([
                'manager_id',
                'status',
                'commission',
                'number',
                'pause_comment',
            ]);
        });
    }
};
