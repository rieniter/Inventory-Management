<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sku>
 */
class SkuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            //
            'product_id' => Product::factory(),
            'code' => strtoupper(fake()->unique()->bothify('???-#####')), // Unique code pattern "ABC-12345"
            'unit_cost' => fake()->numberBetween(1000, 100000),
            'stock' => fake()->numberBetween(0, 9999),
        ];
    }
}
