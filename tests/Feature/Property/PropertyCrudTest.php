<?php

use App\Models\Property;
use App\Models\User;

it('allows an owner to create a property', function () {
    $owner = User::factory()->owner()->create();

    $response = $this->actingAs($owner)->post('/properties', [
        'title' => 'Villa Sunset',
        'city' => 'Taghazout',
        'address' => 'Rue des Palmiers',
        'price_per_night' => 500,
        'capacity' => 4,
        'bedrooms' => 2,
        'bathrooms' => 1,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('properties', ['title' => 'Villa Sunset', 'owner_id' => $owner->id]);
});

it('prevents a guest from creating a property', function () {
    $guest = User::factory()->guest()->create();

    $response = $this->actingAs($guest)->get('/properties/create');

    $response->assertForbidden();
});

it('prevents an owner from editing another owner property', function () {
    $ownerA = User::factory()->owner()->create();
    $ownerB = User::factory()->owner()->create();
    $property = Property::factory()->for($ownerA, 'owner')->create();

    $response = $this->actingAs($ownerB)->put("/properties/{$property->id}", [
        'title' => 'Hijack attempt',
    ]);

    $response->assertForbidden();
});

it('soft deletes a property', function () {
    $owner = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();

    $this->actingAs($owner)->delete("/properties/{$property->id}");

    $this->assertSoftDeleted('properties', ['id' => $property->id]);
});

it('shows only available properties to guests', function () {
    Property::factory()->count(3)->create(['status' => 'available']);
    Property::factory()->create(['status' => 'unavailable']);

    $guest = User::factory()->guest()->create();

    $response = $this->actingAs($guest)->get('/properties');

    $response->assertOk();
    $response->assertViewHas('properties', fn ($properties) => $properties->total() === 3);
});

it('shows owner only their own properties', function () {
    $owner = User::factory()->owner()->create();
    Property::factory()->count(2)->for($owner, 'owner')->create();
    Property::factory()->count(5)->create();

    $response = $this->actingAs($owner)->get('/properties');

    $response->assertViewHas('properties', fn ($properties) => $properties->total() === 2);
});
