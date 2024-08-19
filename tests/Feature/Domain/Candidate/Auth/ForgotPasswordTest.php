<?php

use App\Models\Domain\Candidate\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That candidate user forgot reset link is sent', function () {

    $user = User::factory()->create();

    $response = $this->post("/v1/candidate/auth/forgot-password/{$user->email}");

    expect($response->json()['status'])->toBe('200');

    $this->assertDatabaseCount('password_reset_tokens', 1);

    $this->assertDatabaseHas('password_reset_tokens', [
        'email' => $user->email
    ]);
});


test('That candidate verify forgot reset link is sent', function () {

    $user = User::factory()->create();

    $response = $this->post("/v1/candidate/auth/forgot-password/{$user->email}");

    $response = $this->post("/v1/candidate/auth/verify-forgot-password", [
        'email' => $user->email,
        'token' => str()->random(60),
    ]);

    expect($response->json()['status'])->toBe('300');
});
