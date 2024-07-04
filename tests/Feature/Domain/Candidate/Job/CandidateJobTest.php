<?php

use App\Models\Domain\Candidate\Job\CandidateSavedJob;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Employer\EmployerUser;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That candidate saved a job', function () {

    $user = User::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/job/{$job->uuid}/saveJob");

    expect($response->json()['status'])->toBe('200');

    expect($user->savedJobs->job_ids[0])->toBe(1);
});

test('That candidate unsaved a job', function () {

    $user = User::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    CandidateSavedJob::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/job/{$job->uuid}/saveJob");

    expect($response->json()['status'])->toBe('200');

    expect(count($user->savedJobs->job_ids))->toBe(0);
});

test('That candidate applied for a job', function () {

    $user = User::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/job/applyJob", [
        'applyVia' => 'profile_cv',
        'jobId' => $job->uuid,
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($user->jobApplications->count())->toBe(1);

    expect($user->jobApplications->first()->status)->toBe('applied');
});
