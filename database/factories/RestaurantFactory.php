<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Restaurant;

class RestaurantFactory extends Factory {
    protected $model = Restaurant::class;

    public function definition() {
        return [
            'restaurant_id' => $this->faker->unique()->uuid(),
            'restaurant_name' => $this->faker->name,
            'restaurant_address' => $this->faker->address,
            'restaurant_rating' => $this->faker->randomFloat(1, 0, 5),
        ];
    }
}