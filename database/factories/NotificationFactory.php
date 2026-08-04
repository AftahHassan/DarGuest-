<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'content' => fake()->sentence(),
            'type' => fake()->randomElement([
                'new_reservation', 'new_message', 'emergency', 'reservation_cancelled',
            ]),
            'is_read' => false,
        ];
    }
}
