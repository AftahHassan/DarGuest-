<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Conversation>
 */
class ConversationFactory extends Factory
{
    protected $model = Conversation::class;

    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(),
            'status' => 'open',
            'started_at' => now(),
            'closed_at' => null,
        ];
    }
}
