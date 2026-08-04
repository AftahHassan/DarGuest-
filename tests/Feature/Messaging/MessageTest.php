<?php

use App\Models\Conversation;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Http;

it('sends a message and notifies the other party', function () {
    Http::fake(['*/chat/completions' => Http::response(fakeGroqResponse())]);

    $owner = User::factory()->owner()->create();
    $guest = User::factory()->guest()->create();
    $property = Property::factory()->for($owner, 'owner')->create();
    $reservation = Reservation::factory()->for($property)->create(['guest_id' => $guest->id]);
    $conversation = Conversation::factory()->for($reservation)->create();

    $this->actingAs($guest)->post("/conversations/{$conversation->id}/messages", [
        'message' => 'What is the wifi password?',
    ]);

    $this->assertDatabaseHas('messages', ['conversation_id' => $conversation->id, 'sender_id' => $guest->id]);
    $this->assertDatabaseHas('notifications', ['user_id' => $owner->id, 'type' => 'new_message']);
});

it('prevents a stranger from accessing a conversation', function () {
    $stranger = User::factory()->guest()->create();
    $reservation = Reservation::factory()->create();
    $conversation = Conversation::factory()->for($reservation)->create();

    $response = $this->actingAs($stranger)->get("/reservations/{$reservation->id}");

    $response->assertForbidden();
});

function fakeGroqResponse(): array
{
    return [
        'choices' => [
            ['message' => ['content' => json_encode([
                'language' => 'English',
                'category' => 'wifi',
                'urgent' => false,
                'confidence' => 0.95,
                'response' => 'The Wi-Fi password is 123456.',
            ])]],
        ],
    ];
}
