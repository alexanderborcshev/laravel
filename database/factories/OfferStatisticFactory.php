<?php

namespace Database\Factories;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OfferStatistic>
 */
class OfferStatisticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'new' =>  fake()->numerify('#'),
            'in_progress' => fake()->numerify('#'),
            'postpone' => fake()->numerify('#'),
            'canceled' => fake()->numerify('#'),
            'finished' => fake()->numerify('#'),
            'profit' => fake()->numerify('#'),
            'offer_id' => Offer::all()->random(1)->first()->id,
        ];
    }
}
