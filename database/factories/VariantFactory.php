<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variant>
 */
class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'image' => $this->faker->imageUrl(),
            'variant_name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 0, 9999.99),
            'diskon' => $this->faker->numberBetween(0, 100),
            'qty' => $this->faker->numberBetween(1, 100),
        ];
    }
}
