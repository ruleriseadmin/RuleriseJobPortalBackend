<?php

use Database\Seeders\RoleSeeder;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Admin\AdminUser;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerJob;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test("That admin filter candidate is working", function () {
    $adminUser = AdminUser::factory()->create();

    collect(array_fill(0, 5, 1))->map(fn() => User::factory()->create());

    Employer::factory()->create();

    EmployerJob::factory()->create();

    CandidateJobApplication::factory()->create();

    $response = $this->actingAs($adminUser)->get('v1/admin/candidate');

    expect($response->json()['status'])->toBe('200');
});
