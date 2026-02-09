<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'category_id' => \App\Models\Category::factory(), // Category တစ်ခု အလိုအလျောက် ဆောက်ပေးမည်
            'price' => rand(1000, 50000),
            'stock' => rand(1, 100),
            'description' => $this->faker->sentence(),
            'photo' => 'default.jpg',
        ];
    }
}
