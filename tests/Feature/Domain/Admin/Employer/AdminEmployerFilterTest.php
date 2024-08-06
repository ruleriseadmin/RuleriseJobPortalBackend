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

test("That admin filter candidate is working", function () {
    $adminUser = AdminUser::factory()->create();

    Employer::factory()->create();

    EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    User::factory()->create();

    EmployerJob::factory()->create();

    CandidateJobApplication::factory()->create();

    $response = $this->actingAs($adminUser)->get('v1/admin/employer');

    expect($response->json()['status'])->toBe('200');
});
