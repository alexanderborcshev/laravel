<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->text(15),
            'description' => fake()->paragraph(2),
            'legal_entity' => "OOO ".fake()->text(20),
            'inn' => fake()->numerify('###############'),
            'ogrn' => fake()->numerify('###############'),
            'site' => fake()->word().'.site',
            'api_key' => fake()->uuid(),
        ];
    }
}
