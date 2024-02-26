<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
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
            'name'=>$this->faker->word,
            'body'=>$this->faker->text,
            'price'=>$this->faker->numberBetween(1,1000),
            'user_id'=>$this->faker->randomElement(User::all()->pluck('id')),
            'category_id'=>$this->faker->randomElement(Category::all()->pluck('id')),
        ];
    }
}
