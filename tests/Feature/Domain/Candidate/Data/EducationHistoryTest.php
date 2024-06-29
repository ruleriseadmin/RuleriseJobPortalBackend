<?php

use App\Models\Domain\Candidate\CandidateEducationHistory;
use App\Models\Domain\Candidate\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That candidate education history is created', function(){
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/v1/candidate/education-history', [
        'instituteName' => 'Texas Business Institution',
        'courseName' => 'PGD - Business Analysis',
        'startDate' => '2024-01-01',
        'endDate' => '2024-01-01',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(CandidateEducationHistory::count())->toBe(1);

    expect(CandidateEducationHistory::first()->institute_name)->toBe('Texas Business Institution');
});

test('That candidate education history is updated', function(){
    $user = User::factory()->create();

    $educationHistory = CandidateEducationHistory::factory()->create();

    $response = $this->actingAs($user)->post('/v1/candidate/education-history/update', [
        'uuid' => $educationHistory->uuid,
        'instituteName' => 'New Advance Business Institution',
        'courseName' => 'PGD - Business Analysis',
        'startDate' => '2024-01-01',
        'endDate' => '2024-01-01',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(CandidateEducationHistory::first()->institute_name)->toBe('New Advance Business Institution');
});

test('That candidate education history is deleted', function(){
    $user = User::factory()->create();

    $educationHistory = CandidateEducationHistory::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/education-history/{$educationHistory->uuid}/delete");

    expect($response->json()['status'])->toBe('200');

    expect(CandidateEducationHistory::count())->toBe(0);

    expect(CandidateEducationHistory::onlyTrashed()->count())->toBe(1);
});
