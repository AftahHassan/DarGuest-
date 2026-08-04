<?php

use App\Jobs\AnalyzeMessageJob;
use App\Models\Conversation;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;

it('dispatches the analysis job when a guest sends a message', function () {
    Queue::fake();

    $guest = User::factory()->guest()->create();
    $reservation = Reservation::factory()->create(['guest_id' => $guest->id]);
    $conversation = Conversation::factory()->for($reservation)->create();

    $this->actingAs($guest)->post("/conversations/{$conversation->id}/messages", [
        'message' => 'What time is check-in?',
    ]);

    Queue::assertPushedOn('ai-analysis', AnalyzeMessageJob::class);
});

it('does not dispatch the analysis job when the owner sends a message', function () {
    Queue::fake();

    $owner = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();
    $reservation = Reservation::factory()->for($property)->create();
    $conversation = Conversation::factory()->for($reservation)->create();

    $this->actingAs($owner)->post("/conversations/{$conversation->id}/messages", [
        'message' => 'Sure, check-in is at 3pm.',
    ]);

    Queue::assertNotPushed(AnalyzeMessageJob::class);
});

it('stores the ai analysis and creates an ai message on success', function () {
    Http::fake([
        '*/chat/completions' => Http::response([
            'choices' => [['message' => ['content' => json_encode([
                'language' => 'English',
                'category' => 'wifi',
                'urgent' => false,
                'confidence' => 0.97,
                'response' => 'The Wi-Fi password is 123456.',
            ])]]],
        ]),
    ]);

    $guest = User::factory()->guest()->create();
    $reservation = Reservation::factory()->create(['guest_id' => $guest->id]);
    $conversation = Conversation::factory()->for($reservation)->create();

    $this->actingAs($guest)->post("/conversations/{$conversation->id}/messages", [
        'message' => 'What is the wifi password?',
    ]);

    $message = $conversation->messages()->where('sender_id', $guest->id)->first();

    $this->assertDatabaseHas('ai_analyses', [
        'message_id' => $message->id,
        'category' => 'wifi',
        'urgency' => false,
    ]);
});

it('detects urgency and notifies the owner', function () {
    Http::fake([
        '*/chat/completions' => Http::response([
            'choices' => [['message' => ['content' => json_encode([
                'language' => 'English',
                'category' => 'emergency',
                'urgent' => true,
                'confidence' => 0.99,
                'response' => 'The owner has been notified urgently.',
            ])]]],
        ]),
    ]);

    $owner = User::factory()->owner()->create();
    $guest = User::factory()->guest()->create();
    $property = Property::factory()->for($owner, 'owner')->create();
    $reservation = Reservation::factory()->for($property)->create(['guest_id' => $guest->id]);
    $conversation = Conversation::factory()->for($reservation)->create();

    $this->actingAs($guest)->post("/conversations/{$conversation->id}/messages", [
        'message' => 'There is a water leak in the bathroom!',
    ]);

    $this->assertDatabaseHas('ai_analyses', ['urgency' => true]);
    $this->assertDatabaseHas('notifications', ['user_id' => $owner->id, 'type' => 'emergency']);
});

it('falls back gracefully when groq is unavailable', function () {
    Http::fake(['*/chat/completions' => Http::response([], 503)]);

    $guest = User::factory()->guest()->create();
    $reservation = Reservation::factory()->create(['guest_id' => $guest->id]);
    $conversation = Conversation::factory()->for($reservation)->create();

    $this->actingAs($guest)->post("/conversations/{$conversation->id}/messages", [
        'message' => 'Fire in the kitchen!',
    ]);

    $this->assertDatabaseHas('ai_analyses', ['category' => 'other', 'urgency' => false]);
});

it('falls back gracefully when groq returns invalid json', function () {
    Http::fake([
        '*/chat/completions' => Http::response([
            'choices' => [['message' => ['content' => 'not valid json at all']]],
        ]),
    ]);

    $guest = User::factory()->guest()->create();
    $reservation = Reservation::factory()->create(['guest_id' => $guest->id]);
    $conversation = Conversation::factory()->for($reservation)->create();

    $this->actingAs($guest)->post("/conversations/{$conversation->id}/messages", [
        'message' => 'Test message',
    ]);

    $this->assertDatabaseHas('ai_analyses', ['category' => 'other']);
});
