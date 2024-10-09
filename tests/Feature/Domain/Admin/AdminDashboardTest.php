<?php

use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Domain\Admin\AdminUser;
use App\Models\Domain\Shared\WebsiteCustomization;
use Database\Seeders\OnTimeWebsiteCustomizationSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    $this->seed(OnTimeWebsiteCustomizationSeeder::class);
});

test('That admin view dashboard overview', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->get('/v1/admin/dashboard-overview');

    expect($response->json()['status'])->toBe('200');
});

test('That Candidate account password is changed successfully', function () {

    $user = AdminUser::factory()->create();

    $user['password'] = Hash::make('password1234');

    $response = $this->actingAs($user)->post("/v1/admin/change-password", [
        'currentPassword' => 'password1234',
        'password' => 'password12345',
        'passwordConfirmation' => 'password12345',
    ]);

    $user->refresh();

    expect($response->json()['status'])->toBe('200');

    expect(Hash::check('password12345', $user->password))->toBeTrue();
});
