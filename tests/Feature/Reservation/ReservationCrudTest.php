<?php

use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;

it('creates a reservation with correct total price', function () {
    $guest = User::factory()->guest()->create();
    $property = Property::factory()->create(['price_per_night' => 500]);

    $this->actingAs($guest)->post('/reservations', [
        'property_id' => $property->id,
        'check_in_date' => now()->addDays(5)->toDateString(),
        'check_out_date' => now()->addDays(8)->toDateString(),
        'number_of_guests' => 2,
    ]);

    $this->assertDatabaseHas('reservations', [
        'property_id' => $property->id,
        'total_price' => 1500,
        'status' => 'pending',
    ]);
});

it('automatically creates a conversation with the reservation', function () {
    $guest = User::factory()->guest()->create();
    $property = Property::factory()->create();

    $this->actingAs($guest)->post('/reservations', [
        'property_id' => $property->id,
        'check_in_date' => now()->addDays(5)->toDateString(),
        'check_out_date' => now()->addDays(8)->toDateString(),
        'number_of_guests' => 1,
    ]);

    $reservation = Reservation::latest()->first();
    expect($reservation->conversation)->not->toBeNull();
    expect($reservation->conversation->status)->toBe('open');
});

it('rejects a reservation with checkout before checkin', function () {
    $guest = User::factory()->guest()->create();
    $property = Property::factory()->create();

    $response = $this->actingAs($guest)->post('/reservations', [
        'property_id' => $property->id,
        'check_in_date' => now()->addDays(10)->toDateString(),
        'check_out_date' => now()->addDays(5)->toDateString(),
        'number_of_guests' => 1,
    ]);

    $response->assertSessionHasErrors('check_out_date');
});

it('prevents an owner from creating a reservation', function () {
    $owner = User::factory()->owner()->create();
    $property = Property::factory()->create();

    $response = $this->actingAs($owner)->post('/reservations', [
        'property_id' => $property->id,
        'check_in_date' => now()->addDays(5)->toDateString(),
        'check_out_date' => now()->addDays(8)->toDateString(),
        'number_of_guests' => 1,
    ]);

    $response->assertForbidden();
});
