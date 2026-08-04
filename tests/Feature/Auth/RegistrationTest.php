<?php

use App\Models\User;

it('registers an owner with valid data', function () {
    $response = $this->post('/register', [
        'first_name' => 'Hassan',
        'last_name' => 'Aftah',
        'email' => 'hassan@darguest.test',
        'phone' => '0600000000',
        'role' => 'owner',
        'password' => 'Password123',
        'password_confirmation' => 'Password123',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect('/dashboard');
    $this->assertDatabaseHas('users', [
        'email' => 'hassan@darguest.test',
        'role' => 'owner',
    ]);
});

it('registers a guest with valid data', function () {
    $this->post('/register', [
        'first_name' => 'Sara',
        'last_name' => 'Idrissi',
        'email' => 'sara@darguest.test',
        'role' => 'guest',
        'password' => 'Password123',
        'password_confirmation' => 'Password123',
    ]);

    $this->assertDatabaseHas('users', ['email' => 'sara@darguest.test', 'role' => 'guest']);
});

it('rejects registration with an invalid role', function () {
    $response = $this->post('/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@darguest.test',
        'role' => 'admin',
        'password' => 'Password123',
        'password_confirmation' => 'Password123',
    ]);

    $response->assertSessionHasErrors('role');
});

it('rejects a duplicate email', function () {
    User::factory()->create(['email' => 'exists@darguest.test']);

    $response = $this->post('/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'exists@darguest.test',
        'role' => 'guest',
        'password' => 'Password123',
        'password_confirmation' => 'Password123',
    ]);

    $response->assertSessionHasErrors('email');
});

it('rejects a weak password', function () {
    $response = $this->post('/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'weak@darguest.test',
        'role' => 'guest',
        'password' => 'weak',
        'password_confirmation' => 'weak',
    ]);

    $response->assertSessionHasErrors('password');
});

it('cannot change role after registration', function () {
    $user = User::factory()->guest()->create();

    $this->actingAs($user)->patch('/profile', [
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'email' => $user->email,
        'role' => 'owner',
    ]);

    expect($user->fresh()->role)->toBe('guest');
});
