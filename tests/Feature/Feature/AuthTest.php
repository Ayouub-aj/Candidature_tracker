<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it allows a guest to register with valid data', function () {
    $response = $this->post('/register', [
        'name'                  => 'Test User',
        'email'                 => 'newuser@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
});

test('it blocks registration with invalid data', function () {
    $response = $this->post('/register', [
        'name'                  => '',
        'email'                 => 'not-an-email',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors();
});

test('it allows a registered user to login', function () {
    $user = User::factory()->create([
        'email'    => 'login@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'email'    => 'login@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
});

test('it rejects login with wrong password', function () {
    User::factory()->create([
        'email'    => 'wrong@example.com',
        'password' => bcrypt('password'),
    ]);

    $this->post('/login', [
        'email'    => 'wrong@example.com',
        'password' => 'wrongpassword',
    ]);

    $this->assertGuest();
});

test('it logs out an authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
         ->post('/logout');

    $this->assertGuest();
});

test('it redirects guests to login when accessing dashboard', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirect('/login');
});