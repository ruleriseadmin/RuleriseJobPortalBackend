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

test('That employer filter applicant by per job by all', function () {
    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $job = EmployerJob::factory()->create();

    User::factory()->create();

    CandidateWorkExperience::factory()->create();

    CandidateEducationHistory::factory()->create();

    $application = CandidateJobApplication::factory()->create();
    $application->setStatus('applied');

    $response = $this->actingAs($user)->get("/v1/employer/job/{$job->uuid}/filterApplicantsByJob");

    expect($response->json()['status'])->toBe('200');
});

test('That employer filter applicant by per job by rejected', function () {
    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $job = EmployerJob::factory()->create();

    User::factory()->create();

    CandidateWorkExperience::factory()->create();

    CandidateEducationHistory::factory()->create();

    $application = CandidateJobApplication::factory()->create();

    $application->setStatus('rejected');

    $response = $this->actingAs($user)->get("/v1/employer/job/{$job->uuid}/filterApplicantsByJob?filterBy=rejected&page=1");

    expect($response->json()['status'])->toBe('200');
});

test('That employer filter applicant by per job by offer_sent', function () {
    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $job = EmployerJob::factory()->create();

    User::factory()->create();

    CandidateWorkExperience::factory()->create();

    CandidateEducationHistory::factory()->create();

    $application = CandidateJobApplication::factory()->create();

    $application->setStatus('offer_sent');

    $response = $this->actingAs($user)->get("/v1/employer/job/{$job->uuid}/filterApplicantsByJob?filterBy=offer_sent&page=1");

    expect($response->json()['status'])->toBe('200');
});
