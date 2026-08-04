<?php

namespace Database\Factories;

use App\Models\AiAnalysis;
use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AiAnalysis>
 */
class AiAnalysisFactory extends Factory
{
    protected $model = AiAnalysis::class;

    public function definition(): array
    {
        return [
            'message_id' => Message::factory(),
            'detected_language' => 'English',
            'category' => 'other',
            'urgency' => false,
            'generated_response' => fake()->sentence(),
            'structured_output' => null,
            'confidence' => 0.9,
            'analyzed_at' => now(),
        ];
    }
}
