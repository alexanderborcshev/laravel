<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class ManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'provider_id' => Provider::all()->random(1)->first()->id,
            'user_id' => User::all()->random(1)->first()->id,
        ];
    }
}
