<?php

use App\Models\Conversation;
use App\Models\Notification;
use App\Models\Property;
use App\Models\Recommendation;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

it('only the property owner can update or delete it', function () {
    $owner = User::factory()->owner()->create();
    $stranger = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();

    expect($owner->can('update', $property))->toBeTrue();
    expect($stranger->can('update', $property))->toBeFalse();
    expect($owner->can('delete', $property))->toBeTrue();
    expect($stranger->can('delete', $property))->toBeFalse();
});

it('only guest and property owner can view a reservation', function () {
    $owner = User::factory()->owner()->create();
    $guest = User::factory()->guest()->create();
    $stranger = User::factory()->guest()->create();
    $property = Property::factory()->for($owner, 'owner')->create();
    $reservation = Reservation::factory()->for($property)->create(['guest_id' => $guest->id]);

    expect($guest->can('view', $reservation))->toBeTrue();
    expect($owner->can('view', $reservation))->toBeTrue();
    expect($stranger->can('view', $reservation))->toBeFalse();
});

it('only the owner can update a reservation status', function () {
    $owner = User::factory()->owner()->create();
    $guest = User::factory()->guest()->create();
    $property = Property::factory()->for($owner, 'owner')->create();
    $reservation = Reservation::factory()->for($property)->create(['guest_id' => $guest->id]);

    expect($owner->can('updateStatus', $reservation))->toBeTrue();
    expect($guest->can('updateStatus', $reservation))->toBeFalse();
});

it('every core model has a registered policy', function () {
    $models = [
        Property::class,
        Recommendation::class,
        Reservation::class,
        Conversation::class,
        Notification::class,
    ];

    foreach ($models as $model) {
        $policy = Gate::getPolicyFor(new $model);
        expect($policy)->not->toBeNull("Aucune Policy trouvée pour {$model}");
    }
});
