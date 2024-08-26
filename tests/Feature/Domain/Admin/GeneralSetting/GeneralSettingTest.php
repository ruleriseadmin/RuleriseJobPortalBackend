<?php

use App\Models\Domain\Admin\AdminUser;
use Database\Seeders\GeneralSettingSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    $this->seed(GeneralSettingSeeder::class);
});

test('That admin set view general setting', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->get('/v1/admin/general-setting');

    expect($response->json()['status'])->toBe('200');

    expect(count($response->json()['data']))->toBe(5);
});

test('That admin view updates general setting', function () {
    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post('/v1/admin/general-setting', [
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    expect($response->json()['status'])->toBe('200');
});
