<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'owner_id' => User::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'city' => fake()->randomElement(['Agadir', 'Taghazout', 'Aourir']),
            'address' => fake()->address(),
            'price_per_night' => fake()->numberBetween(200, 1500),
            'capacity' => fake()->numberBetween(1, 8),
            'bedrooms' => fake()->numberBetween(1, 4),
            'bathrooms' => fake()->numberBetween(1, 3),
            'status' => 'available',
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
        ];
    }
}
