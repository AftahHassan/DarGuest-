<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\Recommendation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Recommendation>
 */
class RecommendationFactory extends Factory
{
    protected $model = Recommendation::class;

    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'category' => fake()->randomElement([
                'restaurant', 'cafe', 'beach', 'surf_school', 'taxi',
                'pharmacy', 'hospital', 'supermarket', 'atm',
            ]),
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'website' => null,
        ];
    }
}
