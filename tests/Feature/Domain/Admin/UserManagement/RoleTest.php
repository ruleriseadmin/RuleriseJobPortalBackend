<?php

use App\Models\Domain\Admin\AdminUser;
use App\Models\Domain\Shared\WebsiteCustomization;
use Database\Seeders\AdminPermissionSeeder;
use Database\Seeders\OnTimeWebsiteCustomizationSeeder;
use Database\Seeders\RoleSeeder;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    $this->seed(OnTimeWebsiteCustomizationSeeder::class);
    $this->seed(AdminPermissionSeeder::class);
});

test('That admin view roles', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->get('/v1/admin/user-management/role');

    expect($response->json()['status'])->toBe('200');
});


test('That admin view individual role', function () {

    $user = AdminUser::factory()->create();

    $role = Role::first();

    $response = $this->actingAs($user)->get("/v1/admin/user-management/role/{$role->name}");

    expect($response->json()['status'])->toBe('200');
});

test('That admin create role', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post("/v1/admin/user-management/role", [
        'roleName' => 'Test Role',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(Role::where('name', 'test_role')->count())->toBe(1);
});

test('That admin create role with permission', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post("/v1/admin/user-management/role", [
        'roleName' => 'Test Role',
        'permissions' => ModelsPermission::all()->pluck('name')->toArray(),
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(Role::where('name', 'test_role')->count())->toBe(1);

    expect(Role::where('name', 'test_role')->first()->permissions->count())->toBe(ModelsPermission::all()->count());
});

// test('That admin create role with permission and ensure new user take permission', function () {

//     $user = AdminUser::factory()->create();

//     $response = $this->actingAs($user)->post("/v1/admin/user-management/role", [
//         'roleName' => 'Test Role',
//         'permissions' => ModelsPermission::all()->pluck('name')->toArray(),
//     ]);

//     expect($response->json()['status'])->toBe('200');

//     expect(Role::where('name', 'test_role')->count())->toBe(1);

//     expect(Role::where('name', 'test_role')->first()->permissions->count())->toBe(ModelsPermission::all()->pluck('name')->count());

//     $user->syncRoles(['test_role']);

//     expect($user->getRoleNames()->first())->toBe('test_role');

//     dd( $user->refresh()->getPermissionNames() );

//     expect($user->getPermissionNames())->toBe('test_role');
// });

test('That admin cannot existing create role', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post("/v1/admin/user-management/role", [
        'roleName' => 'super admin',
    ]);

    expect($response->json()['status'])->toBe('payloadValidationError');
});

test('That admin update role', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post("/v1/admin/user-management/role", [
        'roleName' => 'Test Role',
    ]);

    $response = $this->actingAs($user)->post("/v1/admin/user-management/role/update", [
        'slug' => 'test_role',
        'newRoleName' => 'admin',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(Role::where('name', 'admin')->count())->toBe(1);
});

test('That admin cannot update admin role', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post("/v1/admin/user-management/role", [
        'roleName' => 'Test Role',
    ]);

    $response = $this->actingAs($user)->post("/v1/admin/user-management/role/update", [
        'slug' => 'super_admin',
        'newRoleName' => 'admin',
    ]);

    expect($response->json()['status'])->toBe('payloadValidationError');

    expect(Role::where('name', 'super_admin')->where('guard_name', 'admin')->count())->toBe(1);
});

test('That admin delete role', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post("/v1/admin/user-management/role", [
        'roleName' => 'Test Role',
    ]);

    $response = $this->actingAs($user)->post("/v1/admin/user-management/role/test_role/delete");

    expect($response->json()['status'])->toBe('200');

    expect(Role::where('name', 'test_role')->count())->toBe(0);
});

test('That admin cannot delete admin role', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post("/v1/admin/user-management/role/super_admin/delete");

    expect($response->json()['status'])->toBe('200');

    expect(Role::where('name', 'super_admin')->where('guard_name', 'admin')->count())->toBe(1);
});
