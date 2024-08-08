<?php

use Database\Seeders\RoleSeeder;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Admin\AdminUser;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Employer\EmployerUser;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test("That admin view single employer", function () {
    $adminUser = AdminUser::factory()->create();

    $employer = Employer::factory()->create();

    EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    User::factory()->create();

    EmployerJob::factory()->create();

    $application = CandidateJobApplication::factory()->create();

    $application->setStatus('offer_sent');

    $response = $this->actingAs($adminUser)
        ->get("v1/admin/employer/{$employer->uuid}?filterBy=candidate_hired&sortJobBy=close&page=1");

    expect($response->json()['status'])->toBe('200');
});

test("That admin deletes employer", function () {
    $adminUser = AdminUser::factory()->create();

    $employer = Employer::factory()->create();

    EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $response = $this->actingAs($adminUser)->post("v1/admin/employer/{$employer->uuid}/delete");

    expect($response->json()['status'])->toBe('200');

    expect(Employer::count())->toBe(0);

    expect(Employer::onlyTrashed()->count())->toBe(1);

    expect(EmployerUser::count())->toBe(0);

    expect(EmployerUser::onlyTrashed()->count())->toBe(1);
});

test("That admin update employer account status", function () {
    $adminUser = AdminUser::factory()->create();

    $employer = Employer::factory()->create();

    EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $response = $this->actingAs($adminUser)->post("v1/admin/employer/{$employer->uuid}/moderateAccountStatus");

    expect($response->json()['status'])->toBe('200');

    expect($employer->refresh()->active)->toBe(0);
});
