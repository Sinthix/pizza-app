<?php

namespace Database\Factories;

use App\Models\Pizza;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PizzaFactory extends Factory
{
    protected $model = Pizza::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $ingredients = Ingredient::inRandomOrder()->take(rand(1, 5))->pluck('id');

        return [
            'name' => $this->faker->word,
            'selling_price' => $this->faker->randomFloat(2, 5, 20), 
            'image' => null,
            'ingredients' => null
        ];
    }
}
