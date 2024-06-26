<?php

use App\Models\Domain\Candidate\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That candidate user login successful', function () {
    $user = User::factory()->create();

    $response = $this->post('/v1/candidate/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($response->json()['data']['token'])->toBeString();
});
