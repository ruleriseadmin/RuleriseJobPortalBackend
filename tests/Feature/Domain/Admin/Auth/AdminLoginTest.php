<?php

use App\Models\Domain\Admin\AdminUser;
use Database\Seeders\AdminPermissionSeeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    $this->seed(AdminUserSeeder::class);
    $this->seed(AdminPermissionSeeder::class);
});

test('That admin login successfully', function () {
    $user = AdminUser::first();

    $response = $this->post('/v1/admin/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($response->json()['data']['token'])->toBeString();

    dd($response->json());
});
