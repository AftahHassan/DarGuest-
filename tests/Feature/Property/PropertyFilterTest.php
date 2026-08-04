<?php

use App\Models\Property;
use App\Models\User;

it('filters properties by search term', function () {
    Property::factory()->create(['title' => 'Villa Sunset', 'status' => 'available']);
    Property::factory()->create(['title' => 'Appartement Marina', 'status' => 'available']);

    $guest = User::factory()->guest()->create();

    $response = $this->actingAs($guest)->get('/properties?search=Sunset');

    $response->assertViewHas('properties', fn ($properties) => $properties->total() === 1);
});

it('filters properties by city', function () {
    Property::factory()->create(['city' => 'Agadir', 'status' => 'available']);
    Property::factory()->create(['city' => 'Taghazout', 'status' => 'available']);

    $guest = User::factory()->guest()->create();

    $response = $this->actingAs($guest)->get('/properties?city=Taghazout');

    $response->assertViewHas('properties', fn ($properties) => $properties->total() === 1);
});

it('filters properties by price range', function () {
    Property::factory()->create(['price_per_night' => 300, 'status' => 'available']);
    Property::factory()->create(['price_per_night' => 800, 'status' => 'available']);

    $guest = User::factory()->guest()->create();

    $response = $this->actingAs($guest)->get('/properties?price_min=500&price_max=1000');

    $response->assertViewHas('properties', fn ($properties) => $properties->total() === 1);
});

it('sorts properties by price ascending', function () {
    Property::factory()->create(['title' => 'Cheap', 'price_per_night' => 200, 'status' => 'available']);
    Property::factory()->create(['title' => 'Expensive', 'price_per_night' => 900, 'status' => 'available']);

    $guest = User::factory()->guest()->create();

    $response = $this->actingAs($guest)->get('/properties?sort=price_asc');

    $response->assertViewHas('properties', fn ($properties) => $properties->first()->title === 'Cheap');
});
