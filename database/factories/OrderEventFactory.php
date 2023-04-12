<?php

namespace Database\Factories;

use App\Models\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderEvent>
 */
class OrderEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random(1)->first()->id,
            'order_id' => Order::all()->random(1)->first()->id,
            'comment' => fake()->paragraph(1),
            'code' => collect(OrderStatusEnum::names())->random(),
        ];
    }
}
