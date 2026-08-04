<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PropertyInfo>
 */
class PropertyInfoFactory extends Factory
{
    protected $model = PropertyInfo::class;

    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'wifi_name' => fake()->word().'_WiFi',
            'wifi_password' => fake()->password(8, 12),
            'check_in' => '15:00',
            'check_out' => '11:00',
            'parking' => fake()->boolean(),
            'parking_info' => fake()->optional()->sentence(),
            'access_instructions' => fake()->optional()->paragraph(),
            'house_rules' => fake()->optional()->paragraph(),
        ];
    }
}
