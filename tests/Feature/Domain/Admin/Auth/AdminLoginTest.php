<?php

use App\Models\Domain\Admin\AdminUser;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That admin login successfully', function () {
    $user = AdminUser::factory()->create();

    $response = $this->post('/v1/admin/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($response->json()['data']['token'])->toBeString();
});
