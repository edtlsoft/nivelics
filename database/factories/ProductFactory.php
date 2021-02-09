<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Provider;
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
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 1000, 100000),
            'quantity' => $this->faker->numberBetween(10, 1500),
            'provider_id' => function(){
                return Provider::factory()->create();
            },
        ];
    }
}
