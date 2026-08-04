<?php

use App\Models\User;

it('registers via api and returns a token', function () {
    $response = $this->postJson('/api/register', [
        'first_name' => 'Api',
        'last_name' => 'User',
        'email' => 'apiuser@darguest.test',
        'role' => 'owner',
        'password' => 'Password123',
        'password_confirmation' => 'Password123',
    ]);

    $response->assertCreated()->assertJsonStructure(['token', 'user']);
});

it('logs in via api and returns a token', function () {
    $user = User::factory()->create(['password' => bcrypt('Password123')]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'Password123',
    ]);

    $response->assertOk()->assertJsonStructure(['token']);
});

it('rejects an unauthenticated request to a protected endpoint', function () {
    $this->getJson('/api/me')->assertUnauthorized();
});

it('accepts a valid bearer token', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test')->plainTextToken;

    $this->withToken($token)->getJson('/api/me')->assertOk();
});
