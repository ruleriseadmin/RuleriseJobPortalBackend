<?php

use App\Models\Domain\Candidate\CandidateLanguage;
use App\Models\Domain\Candidate\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That candidate language is created', function(){
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/v1/candidate/language', [
        'language' => 'English',
        'proficiency' => 'native',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(CandidateLanguage::count())->toBe(1);

    expect(CandidateLanguage::first()->language)->toBe('English');
});

test('That candidate language is updated', function(){
    $user = User::factory()->create();

    $language = CandidateLanguage::factory()->create();

    $response = $this->actingAs($user)->post('/v1/candidate/language/update', [
        'uuid' => $language->uuid,
        'language' => 'French',
        'proficiency' => 'native',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(CandidateLanguage::first()->language)->toBe('French');
});

test('That candidate language is deleted', function(){
    $user = User::factory()->create();

    $language = CandidateLanguage::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/language/{$language->uuid}/delete");

    expect($response->json()['status'])->toBe('200');

    expect(CandidateLanguage::count())->toBe(0);

    expect(CandidateLanguage::onlyTrashed()->count())->toBe(1);
});
