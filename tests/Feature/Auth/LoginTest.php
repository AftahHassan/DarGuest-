<?php

use App\Models\User;

it('logs in with correct credentials', function () {
    $user = User::factory()->create(['password' => bcrypt('Password123')]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'Password123',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect('/dashboard');
});

it('rejects login with wrong password', function () {
    $user = User::factory()->create(['password' => bcrypt('Password123')]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'WrongPassword',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors();
});

it('logs out an authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/logout');

    $this->assertGuest();
});

it('redirects owner and guest to the same dashboard route after login', function () {
    $owner = User::factory()->owner()->create(['password' => bcrypt('Password123')]);

    $response = $this->post('/login', ['email' => $owner->email, 'password' => 'Password123']);

    $response->assertRedirect('/dashboard');
});
