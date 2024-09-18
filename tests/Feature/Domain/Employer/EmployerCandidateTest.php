<?php

use App\Models\Domain\Candidate\CandidateCredential;
use App\Models\Domain\Candidate\CandidateEducationHistory;
use App\Models\Domain\Candidate\CandidateLanguage;
use App\Models\Domain\Candidate\CandidatePortfolio;
use App\Models\Domain\Candidate\CandidateQualification;
use App\Models\Domain\Candidate\CandidateWorkExperience;
use App\Models\Domain\Candidate\CVDocument;
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

test('That employer filter job candidates via cv upload', function () {
    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    User::factory()->create();

    $cv = CVDocument::factory()->create();

    $job = EmployerJob::factory()->create();


    CandidateWorkExperience::factory()->create();

    CandidateEducationHistory::factory()->create();

    $application = CandidateJobApplication::factory()->create();
    $application->update([
        'cv_url' => $cv->id,
        'applied_via' => 'custom_cv',
    ]);
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

    CandidatePortfolio::factory()->create();

    CandidateCredential::factory()->create();

    CandidateLanguage::factory()->create();

    CandidateQualification::factory()->create();

    $application = CandidateJobApplication::factory()->create();
    $application->setStatus('applied');

    $response = $this->actingAs($user)->get("/v1/employer/candidate/{$candidate->uuid}");

    expect($response->json()['status'])->toBe('200');
});

test('That employer view single job application', function () {
    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $job = EmployerJob::factory()->create();

    $candidate = User::factory()->create();

    CandidateWorkExperience::factory()->create();

    CandidateEducationHistory::factory()->create();

    CandidatePortfolio::factory()->create();

    CandidateCredential::factory()->create();

    CandidateLanguage::factory()->create();

    CandidateQualification::factory()->create();

    $application = CandidateJobApplication::factory()->create();
    $application->setStatus('applied');

    $response = $this->actingAs($user)->get("/v1/employer/job/{$application->uuid}/view-application");

    expect($response->json()['status'])->toBe('200');
});
