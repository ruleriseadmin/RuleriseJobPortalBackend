<?php

use App\Models\Domain\Candidate\CandidateWorkExperience;
use App\Models\Domain\Candidate\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That candidate work experience is created', function(){
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/v1/candidate/work-experience', [
        'roleTitle' => 'ceo',
        'companyName' => 'rulerise',
        'startDate' => '2024-01-01',
        'endDate' => '2024-01-01',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(CandidateWorkExperience::count())->toBe(1);

    expect(CandidateWorkExperience::first()->role_title)->toBe('ceo');
});

test('That candidate work experience is updated', function(){
    $user = User::factory()->create();

    $workExperience = CandidateWorkExperience::factory()->create();

    $response = $this->actingAs($user)->post('/v1/candidate/work-experience/update', [
        'uuid' => $workExperience->uuid,
        'roleTitle' => 'cfo',
        'companyName' => 'rulerise',
        'startDate' => '2024-01-01',
        'endDate' => '2024-01-01',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(CandidateWorkExperience::first()->role_title)->toBe('cfo');
});

test('That candidate work experience is deleted', function(){
    $user = User::factory()->create();

    $workExperience = CandidateWorkExperience::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/work-experience/{$workExperience->uuid}/delete");

    expect($response->json()['status'])->toBe('200');

    expect(CandidateWorkExperience::count())->toBe(0);

    expect(CandidateWorkExperience::onlyTrashed()->count())->toBe(1);
});
