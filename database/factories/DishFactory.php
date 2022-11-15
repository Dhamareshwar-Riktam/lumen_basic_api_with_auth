<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Dish;


class DishFactory extends Factory {
    protected $model = Dish::class;

    public function definition() {
        return [
            'dish_id' => $this->faker->unique()->uuid(),
            'dish_name' => $this->faker->name,
            'dish_description' => $this->faker->text,
            'dish_price' => $this->faker-> randomNumber(4),
            'dish_rating' => $this->faker->randomFloat(1, 0, 5),
            'restaurant_id' => $this->faker->unique()->uuid(),
        ];
    }
}