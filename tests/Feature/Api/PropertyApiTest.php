<?php

use App\Models\User;

it('creates a property via api as owner', function () {
    $owner = User::factory()->owner()->create();

    $response = $this->actingAs($owner, 'sanctum')->postJson('/api/properties', [
        'title' => 'API Villa',
        'city' => 'Agadir',
        'address' => 'Test address',
        'price_per_night' => 400,
        'capacity' => 3,
        'bedrooms' => 2,
        'bathrooms' => 1,
    ]);

    $response->assertCreated();
});

it('rejects property creation via api as guest', function () {
    $guest = User::factory()->guest()->create();

    $response = $this->actingAs($guest, 'sanctum')->postJson('/api/properties', ['title' => 'Test']);

    $response->assertForbidden();
});
