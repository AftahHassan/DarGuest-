<?php

use App\Models\Property;
use App\Models\User;

it('creates property info when none exists (upsert)', function () {
    $owner = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();

    $this->actingAs($owner)->put("/properties/{$property->id}/info", [
        'wifi_name' => 'DarGuest_WiFi',
        'wifi_password' => 'secret123',
        'check_in' => '15:00',
        'check_out' => '11:00',
        'parking' => true,
    ]);

    $this->assertDatabaseHas('property_infos', [
        'property_id' => $property->id,
        'wifi_name' => 'DarGuest_WiFi',
    ]);
});

it('updates existing property info instead of duplicating', function () {
    $owner = User::factory()->owner()->create();
    $property = Property::factory()->for($owner, 'owner')->create();
    $property->info()->create(['wifi_name' => 'Old_WiFi']);

    $this->actingAs($owner)->put("/properties/{$property->id}/info", [
        'wifi_name' => 'New_WiFi',
    ]);

    expect($property->info()->count())->toBe(1);
    expect($property->info->fresh()->wifi_name)->toBe('New_WiFi');
});
