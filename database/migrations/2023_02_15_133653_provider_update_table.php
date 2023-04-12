<?php

use App\Models\Enums\ProviderStatusEnum;
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
            $table->string('status')->default(ProviderStatusEnum::active->name);
            $table->string('first_name')->default('');
            $table->string('second_name')->default('');
            $table->string('last_name')->default('');
            $table->string('phone')->default('');
            $table->string('email')->default('');
            $table->string('kpp')->default('');
            $table->string('checking_account')->default('');
            $table->string('bik')->default('');
            $table->string('bank')->default('');
            $table->string('ur_address')->default('');
            $table->string('post_address')->default('');
            $table->string('form_business')->default('');
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
                'status',
                'first_name',
                'second_name',
                'last_name',
                'phone',
                'email',
                'kpp',
                'checking_account',
                'bik',
                'bank',
                'ur_address',
                'post_address',
                'form_business',
            ]);
        });
    }
};
