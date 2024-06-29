<?php

use App\Models\Domain\Candidate\CandidateCredential;
use App\Models\Domain\Candidate\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That candidate credential is created', function(){
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/v1/candidate/credential', [
        'name' => 'Drivers License',
        'type' => 'License',
        'dateIssued' => '2024-01-01',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(CandidateCredential::count())->toBe(1);

    expect(CandidateCredential::first()->name)->toBe('Drivers License');
});

test('That candidate credential is updated', function(){
    $user = User::factory()->create();

    $credential = CandidateCredential::factory()->create();

    $response = $this->actingAs($user)->post('/v1/candidate/credential/update', [
        'uuid' => $credential->uuid,
        'name' => 'Other License',
        'type' => 'License',
        'dateIssued' => '2024-01-01',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(CandidateCredential::first()->name)->toBe('Other License');
});

test('That candidate credential is deleted', function(){
    $user = User::factory()->create();

    $credential = CandidateCredential::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/credential/{$credential->uuid}/delete");

    expect($response->json()['status'])->toBe('200');

    expect(CandidateCredential::count())->toBe(0);

    expect(CandidateCredential::onlyTrashed()->count())->toBe(1);
});
