<?php

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(fn () => Storage::fake('public'));

it('uploads multiple images to a property', function () {
    $owner = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();

    $response = $this->actingAs($owner)->post("/properties/{$property->id}/images", [
        'images' => [
            UploadedFile::fake()->create('photo1.jpg', 100, 'image/jpeg'),
            UploadedFile::fake()->create('photo2.jpg', 100, 'image/jpeg'),
        ],
    ]);

    $response->assertRedirect();
    expect($property->images()->count())->toBe(2);
});

it('rejects an image upload larger than 4mb', function () {
    $owner = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();

    $response = $this->actingAs($owner)->post("/properties/{$property->id}/images", [
        'images' => [UploadedFile::fake()->create('big.jpg', 5000)],
    ]);

    $response->assertSessionHasErrors();
});

it('deletes an image and its file from storage', function () {
    $owner = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();
    $image = $property->images()->create(['image' => 'properties/test.jpg', 'position' => 0]);
    Storage::disk('public')->put('properties/test.jpg', 'fake-content');

    $this->actingAs($owner)->delete("/property-images/{$image->id}");

    $this->assertDatabaseMissing('property_images', ['id' => $image->id]);
    Storage::disk('public')->assertMissing('properties/test.jpg');
});

it('prevents a non-owner from deleting an image', function () {
    $owner = User::factory()->owner()->create();
    $otherOwner = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();
    $image = $property->images()->create(['image' => 'properties/test.jpg', 'position' => 0]);

    $response = $this->actingAs($otherOwner)->delete("/property-images/{$image->id}");

    $response->assertForbidden();
});
