<?php

use App\Models\Domain\Candidate\CandidateEducationHistory;
use App\Models\Domain\Candidate\CandidateWorkExperience;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Employer\EmployerUser;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That employer filter job candidates', function () {
    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $job = EmployerJob::factory()->create();

    User::factory()->create();

    CandidateWorkExperience::factory()->create();

    CandidateEducationHistory::factory()->create();

    $application = CandidateJobApplication::factory()->create();
    $application->setStatus('applied');

    $response = $this->actingAs($user)->get("/v1/employer/candidate");

    expect($response->json()['status'])->toBe('200');
});

test('That employer view single candidate', function () {
    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $job = EmployerJob::factory()->create();

    $candidate = User::factory()->create();

    CandidateWorkExperience::factory()->create();

    CandidateEducationHistory::factory()->create();

    $application = CandidateJobApplication::factory()->create();
    $application->setStatus('applied');

    $response = $this->actingAs($user)->get("/v1/employer/candidate/{$candidate->uuid}");

    expect($response->json()['status'])->toBe('200');

    dd($response->json());
});
