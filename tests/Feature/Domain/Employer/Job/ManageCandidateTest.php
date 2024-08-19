<?php

use App\Models\Domain\Candidate\CandidateEducationHistory;
use App\Models\Domain\Candidate\CandidateWorkExperience;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Employer\EmployerUser;
use App\Models\Domain\Employer\Template\JobNotificationTemplate;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That employer change multiple job applicant hiring stage', function () {
    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $job = EmployerJob::factory()->create();

    $candidate = User::factory()->create();

    $application = CandidateJobApplication::factory()->create();

    $application->setStatus('unsorted');

    JobNotificationTemplate::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/candidate/application/change-hiring-stage", [
        'hiringStage' => 'rejected',
        'applicationIds' => [$application->uuid],
    ]);

    $application->refresh();

    expect($response->json()['status'])->toBe('200');

    expect($application->status())->toBe('rejected');
});
