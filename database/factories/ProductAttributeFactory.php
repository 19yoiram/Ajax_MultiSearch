<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttribute>
 */
class ProductAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $keys = ['Color', 'Size', 'Material', 'Weight'];
        $values = [
            'Color' => ['Red', 'Blue', 'Green', 'Black'],
            'Size' => ['S', 'M', 'L', 'XL'],
            'Material' => ['Cotton', 'Leather', 'Polyester'],
            'Weight' => ['0.5kg', '1kg', '2kg']
        ];

        $key = $this->faker->randomElement($keys);

        return [
            'product_id' => Product::inRandomOrder()->first()?->id ?? 1,
            'key' => $key,
            'value' => $this->faker->randomElement($values[$key]),
        ];
    }
}
