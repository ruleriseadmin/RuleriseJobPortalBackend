<?php

use App\Models\Domain\Admin\AdminUser;
use App\Models\Domain\Shared\WebsiteCustomization;
use Database\Seeders\OnTimeWebsiteCustomizationSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    $this->seed(OnTimeWebsiteCustomizationSeeder::class);
});

test('That admin set website customization', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post('/v1/admin/website-customization', [
        'type' => 'hero_section',
        'sections' => [
            ['name' => 'banner_one', 'value' => 'Founders vision'],
            ['name' => 'subtitle_one', 'value' => 'Hello'],
            ['name' => 'banner_two', 'value' => 'Hello'],
            ['name' => 'subtitle_two', 'value' => 'Hello'],
            ['name' => 'subtitle_three', 'value' => 'Hello'],
            ['name' => 'banner_three', 'value' => 'Hello'],
        ],
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(WebsiteCustomization::first()->value)->toBeString('Founders vision');
});

test('That admin view website customization', function () {
    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->get('/v1/admin/website-customization/hero_section');

    expect($response->json()['status'])->toBe('200');
});

test('That admin website customization add new contact', function () {
    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post('/v1/admin/website-customization/createNewContact', [
        'title' => 'twitter',
        'link' => 'twitter.com/account',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(WebsiteCustomization::where('name', 'twitter')->first()->value)->toBe('twitter.com/account');
});
