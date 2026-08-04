<?php

use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;

it('lets the owner confirm a pending reservation', function () {
    $owner = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();
    $reservation = Reservation::factory()->for($property)->create(['status' => 'pending']);

    $this->actingAs($owner)->patch("/reservations/{$reservation->id}/status", ['status' => 'confirmed']);

    expect($reservation->fresh()->status)->toBe('confirmed');
});

it('prevents a guest from confirming a reservation', function () {
    $guest = User::factory()->guest()->create();
    $reservation = Reservation::factory()->create(['guest_id' => $guest->id, 'status' => 'pending']);

    $response = $this->actingAs($guest)->patch("/reservations/{$reservation->id}/status", ['status' => 'confirmed']);

    $response->assertForbidden();
});

it('allows the guest to cancel their own reservation', function () {
    $guest = User::factory()->guest()->create();
    $reservation = Reservation::factory()->create(['guest_id' => $guest->id, 'status' => 'pending']);

    $this->actingAs($guest)->patch("/reservations/{$reservation->id}/cancel");

    expect($reservation->fresh()->status)->toBe('cancelled');
});

it('allows the owner to cancel a reservation on their property', function () {
    $owner = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();
    $reservation = Reservation::factory()->for($property)->create(['status' => 'pending']);

    $this->actingAs($owner)->patch("/reservations/{$reservation->id}/cancel");

    expect($reservation->fresh()->status)->toBe('cancelled');
});

it('notifies the other party when a reservation is cancelled', function () {
    $owner = User::factory()->owner()->create();
    $guest = User::factory()->guest()->create();
    $property = Property::factory()->for($owner, 'owner')->create();
    $reservation = Reservation::factory()->for($property)->create(['guest_id' => $guest->id]);

    $this->actingAs($guest)->patch("/reservations/{$reservation->id}/cancel");

    $this->assertDatabaseHas('notifications', [
        'user_id' => $owner->id,
        'type' => 'reservation_cancelled',
    ]);
});
