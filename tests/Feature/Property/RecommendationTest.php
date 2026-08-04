<?php

use App\Models\Property;
use App\Models\Recommendation;
use App\Models\User;

it('adds a recommendation to a property', function () {
    $owner = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();

    $this->actingAs($owner)->post("/properties/{$property->id}/recommendations", [
        'category' => 'restaurant',
        'title' => 'Sunset Beach Restaurant',
    ]);

    $this->assertDatabaseHas('recommendations', ['property_id' => $property->id, 'title' => 'Sunset Beach Restaurant']);
});

it('rejects an invalid category', function () {
    $owner = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();

    $response = $this->actingAs($owner)->post("/properties/{$property->id}/recommendations", [
        'category' => 'nightclub',
        'title' => 'Test',
    ]);

    $response->assertSessionHasErrors('category');
});

it('deletes a recommendation', function () {
    $owner = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();
    $recommendation = Recommendation::factory()->for($property)->create();

    $this->actingAs($owner)->delete("/recommendations/{$recommendation->id}");

    $this->assertDatabaseMissing('recommendations', ['id' => $recommendation->id]);
});
