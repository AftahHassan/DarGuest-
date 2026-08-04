<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        return [
            'guest_id' => User::factory(),
            'property_id' => Property::factory(),
            'check_in_date' => now()->addDays(5)->toDateString(),
            'check_out_date' => now()->addDays(8)->toDateString(),
            'number_of_guests' => fake()->numberBetween(1, 4),
            'total_price' => 0,
            'status' => 'pending',
            'special_request' => null,
        ];
    }
}
