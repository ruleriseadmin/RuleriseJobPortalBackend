<?php

use App\Models\Domain\Admin\AdminUser;
use App\Models\Domain\Shared\WebsiteCustomization;
use Database\Seeders\AdminPermissionSeeder;
use Database\Seeders\OnTimeWebsiteCustomizationSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    $this->seed(OnTimeWebsiteCustomizationSeeder::class);
    $this->seed(AdminPermissionSeeder::class);
});

test('That admin create user with permissions', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post('/v1/admin/user-management/user', [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'password' => 'password001',
        'email' => 'admin@example.com',
        'role' => 'super_admin',
        'permissions' => [
            'website crm',
            'candidate',
            'employer',
        ],
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(AdminUser::count())->toBe(2);

    $user = AdminUser::where('email', 'admin@example.com')->first();

    expect(AdminUser::where('email', 'admin@example.com')->count())->toBe(1);

    expect($user->roles->pluck('name')->first())->toBe('super_admin');

    expect($user->full_name)->toBe('John Doe');

    expect($user->hasAllPermissions(['website crm', 'candidate', 'employer']))->toBeTrue();
});

test('That admin create views all permissions', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->get('/v1/admin/user-management/permissions');

    expect($response->json()['status'])->toBe('200');
});

test('That admin view users', function () {

    $user = AdminUser::factory()->create();

    collect(array_fill(0, 5, 1))->map(fn() => AdminUser::factory()->create());

    $response = $this->actingAs($user)->get('/v1/admin/user-management/user?page=1');

    expect($response->json()['status'])->toBe('200');
});

test('That admin view single user', function () {

    $user = AdminUser::factory()->create();

    $user->assignRole('super_admin');

    $response = $this->actingAs($user)->get("/v1/admin/user-management/user/{$user->uuid}");

    expect($response->json()['status'])->toBe('200');
});

test('That admin create user', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post('/v1/admin/user-management/user', [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'password' => 'password001',
        'email' => 'admin@example.com',
        'role' => 'super_admin'
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(AdminUser::count())->toBe(2);

    $user = AdminUser::where('email', 'admin@example.com')->first();

    expect(AdminUser::where('email', 'admin@example.com')->count())->toBe(1);

    expect($user->roles->pluck('name')->first())->toBe('super_admin');

    expect($user->full_name)->toBe('John Doe');
});

test('That admin update user', function () {

    $user = AdminUser::factory()->create();

    $user->assignRole('super_admin');

    $response = $this->actingAs($user)->post('/v1/admin/user-management/user/update', [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'password' => 'password001',
        'email' => 'admin@example.com',
        'role' => 'super_admin',
        'userId' => $user->uuid,
    ]);

    expect($response->json()['status'])->toBe('200');

    $user = AdminUser::where('email', 'admin@example.com')->first();

    expect(AdminUser::where('email', 'admin@example.com')->count())->toBe(1);

    expect($user->getRoleNames()->first())->toBe('super_admin');

    expect($user->full_name)->toBe('John Doe');
});

test('That admin cannot update main user role', function () {

    $user = AdminUser::factory()->create();

    $user->assignRole('super_admin');

    $response = $this->actingAs($user)->post("/v1/admin/user-management/role", [
        'roleName' => 'Test Role',
    ]);

    $response = $this->actingAs($user)->post('/v1/admin/user-management/user/update', [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'password' => 'password001',
        'email' => 'admin@example.com',
        'role' => 'test_role',
        'userId' => $user->uuid,
    ]);

    expect($response->json()['status'])->toBe('200');

    $user = AdminUser::where('email', 'admin@example.com')->first();

    expect(AdminUser::where('email', 'admin@example.com')->count())->toBe(1);

    expect($user->getRoleNames()->first())->toBe('super_admin');

    expect($user->full_name)->toBe('John Doe');
});

test('That admin delete user', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post('/v1/admin/user-management/user', [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'password' => 'password001',
        'email' => 'admin@example.com',
        'role' => 'super_admin'
    ]);

    $user = AdminUser::where('email', 'admin@example.com')->first();

    $response = $this->actingAs($user)->post("/v1/admin/user-management/user/{$user->uuid}/delete");

    expect($response->json()['status'])->toBe('200');

    expect(AdminUser::count())->toBe(1);

    expect(AdminUser::onlyTrashed()->count())->toBe(1);
});

test('That admin cannot delete main user', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post("/v1/admin/user-management/user/{$user->uuid}/delete");

    expect($response->json()['status'])->toBe('300');

    expect(AdminUser::count())->toBe(1);

    expect(AdminUser::onlyTrashed()->count())->toBe(0);
});
