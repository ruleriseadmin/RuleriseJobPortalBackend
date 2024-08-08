<?php

use Database\Seeders\RoleSeeder;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Admin\AdminUser;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Candidate\CVDocument;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Candidate\CandidateLanguage;
use App\Models\Domain\Candidate\CandidatePortfolio;
use App\Models\Domain\Candidate\CandidateCredential;
use App\Models\Domain\Candidate\CandidateQualification;
use App\Models\Domain\Candidate\CandidateWorkExperience;
use App\Models\Domain\Candidate\CandidateEducationHistory;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test("That admin view single candidate", function () {
    $adminUser = AdminUser::factory()->create();

    $candidate = User::factory()->create();

    $workExperiences = CandidateWorkExperience::factory()->create();

    $qualifications = CandidateQualification::factory()->create();

    $portfolio = CandidatePortfolio::factory()->create();

    $languages = CandidateLanguage::factory()->create();

    $educationHistories = CandidateEducationHistory::factory()->create();

    $credentials = CandidateCredential::factory()->create();

    CVDocument::factory()->create();

    Employer::factory()->create();

    EmployerJob::factory()->create();

    $application = CandidateJobApplication::factory()->create();

    $application->setStatus('applied');

    $response = $this->actingAs($adminUser)->get("v1/admin/candidate/{$candidate->uuid}/?filterBy=job_application");

    expect($response->json()['status'])->toBe('200');
});

test("That admin delete candidate", function () {
    $adminUser = AdminUser::factory()->create();

    $candidate = User::factory()->create();

    $response = $this->actingAs($adminUser)->post("v1/admin/candidate/{$candidate->uuid}/delete");

    expect($response->json()['status'])->toBe('200');

    expect(User::count())->toBe(0);

    expect(User::onlyTrashed()->count())->toBe(1);
});

test("That admin update candidate account status", function () {
    $adminUser = AdminUser::factory()->create();

    $candidate = User::factory()->create();

    $response = $this->actingAs($adminUser)->post("v1/admin/candidate/{$candidate->uuid}/moderateAccountStatus");

    expect($response->json()['status'])->toBe('200');

    expect((bool) $candidate->refresh()->active)->toBeFalse();
});

test("That admin set shadow on candidate", function () {
    $adminUser = AdminUser::factory()->create();

    $candidate = User::factory()->create();

    $response = $this->actingAs($adminUser)->post("v1/admin/candidate/{$candidate->uuid}/setShadowBan", [
        'type' => 'ban_apply_job',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect((bool) $candidate->refresh()->hasBan('ban_apply_job'))->toBeTrue();
});
