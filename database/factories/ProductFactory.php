<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'brand' => $this->faker->company(),
            'rating' => $this->faker->randomFloat(1, 1, 5), 
            'price' => $this->faker->numberBetween($min = 100000, $max = 250000),
            'description' => $this->faker->paragraph(),
        ];
    }
}
