<?php

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Employer\EmployerUser;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That employer user forgot reset link is sent', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $response = $this->post("/v1/employer/auth/forgot-password/{$user->email}");

    expect($response->json()['status'])->toBe('200');

    $this->assertDatabaseCount('password_reset_tokens', 1);

    $this->assertDatabaseHas('password_reset_tokens', [
        'email' => $user->email
    ]);
});
