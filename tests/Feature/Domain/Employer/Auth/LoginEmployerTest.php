<?php

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Employer\EmployerUser;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That employer user login successful', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $response = $this->post('/v1/employer/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($response->json()['data']['token'])->toBeString();
});
