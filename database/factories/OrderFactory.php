<?php

namespace Database\Factories;

use App\Models\Enums\OrderStatusEnum;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $offer = Offer::all()->random(1)->first();
        return [
            'provider_id' => $offer->provider_id,
            'offer_id' => $offer->id,
            'phone' => fake()->unique()->numerify('89#########'),
            'name' => fake()->name(),
            'email' => fake()->email(),
            'comment' => fake()->paragraph(),
            'status' => fake()->randomElement(OrderStatusEnum::names()),
            'created_at' => fake()->dateTime(),
        ];
    }
}
