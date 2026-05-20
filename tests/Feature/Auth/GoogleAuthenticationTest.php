<?php

use Illuminate\Support\Facades\Http;
use App\Models\User;

test('login page shows google sign in button', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    $response->assertSee('Continue with Google');
    $response->assertSee(route('auth.google.redirect'));
});

test('registration page shows google sign in button', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
    $response->assertSee('Continue with Google');
    $response->assertSee(route('auth.google.redirect'));
});

test('google redirect route begins oauth flow', function () {
    config([
        'services.google.client_id' => 'google-client-id',
        'services.google.client_secret' => 'google-secret',
        'services.google.redirect' => 'http://localhost:8000/auth/google/callback',
    ]);

    $response = $this->get(route('auth.google.redirect'));

    $response->assertRedirect();
    $response->assertRedirectContains('https://accounts.google.com/o/oauth2/v2/auth');
});

test('google callback creates user and logs in', function () {
    config([
        'services.google.client_id' => 'google-client-id',
        'services.google.client_secret' => 'google-secret',
        'services.google.redirect' => 'http://localhost:8000/auth/google/callback',
    ]);

    Http::fake([
        'https://oauth2.googleapis.com/token' => Http::response([
            'access_token' => 'fake-access-token',
            'expires_in' => 3600,
            'token_type' => 'Bearer',
        ], 200),
        'https://openidconnect.googleapis.com/v1/userinfo' => Http::response([
            'sub' => 'google-user-id',
            'email' => 'test@example.com',
            'name' => 'Test User',
        ], 200),
    ]);

    $response = $this->get(route('auth.google.callback', ['code' => 'test-code']));

    $response->assertRedirect(route('dashboard', absolute: false));
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'google_id' => 'google-user-id',
    ]);
});
