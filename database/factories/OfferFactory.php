<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $provider = Provider::all()->random(1)->first();
        return [
            'name' =>  fake()->text(15),
            'orders_count' => 0,
            'price_min' => fake()->numerify(),
            'price_max' => fake()->numerify('#####'),
            'provider_id' => $provider->id,
            'manager_id' => $provider->managers()->first()->id,
            'main_text' => fake()->paragraph(),
            'main_text_title' => fake()->paragraph(),
            'description' => fake()->paragraph(),
            'commission' => fake()->numerify('##'),
            'category_id' => Category::all()->random(1)->first(),
            'prices' => '[{"from": true, "price": "500 руб.", "measure": 2, "description": "Черновые электромонтажные работы"}, {"from": true, "price": "500 руб.", "measure": 1, "description": "Установка одной розетки"}, {"from": true, "price": "от 2 500 000 руб.", "measure": 1, "description": "Домокомплект"}]',
            'gifts' => '["Обработка заказа вне очереди", "Бесплатная доставка до двери", "Шлифовальный диск в подарок"]',
        ];
    }
}
