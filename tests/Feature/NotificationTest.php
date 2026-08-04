<?php

use App\Models\Notification;
use App\Models\User;

it('lists only the authenticated user notifications', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    Notification::factory()->for($user)->count(3)->create();
    Notification::factory()->for($other)->count(2)->create();

    $response = $this->actingAs($user)->get('/notifications');

    $response->assertViewHas('notifications', fn ($n) => $n->total() === 3);
});

it('marks a single notification as read', function () {
    $user = User::factory()->create();
    $notification = Notification::factory()->for($user)->create(['is_read' => false]);

    $this->actingAs($user)->post("/notifications/{$notification->id}/read");

    expect($notification->fresh()->is_read)->toBeTrue();
});

it('prevents marking another user notification as read', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $notification = Notification::factory()->for($other)->create();

    $response = $this->actingAs($user)->post("/notifications/{$notification->id}/read");

    $response->assertForbidden();
});

it('marks all notifications as read at once', function () {
    $user = User::factory()->create();
    Notification::factory()->for($user)->count(4)->create(['is_read' => false]);

    $this->actingAs($user)->post('/notifications/read-all');

    expect(Notification::where('user_id', $user->id)->where('is_read', false)->count())->toBe(0);
});
