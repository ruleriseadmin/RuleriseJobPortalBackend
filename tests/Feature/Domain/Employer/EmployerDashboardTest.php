<?php

use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\Job\EmployerJobViewCount;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Employer\EmployerUser;
use App\Models\Domain\Employer\EmployerAccess;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That employer dashboard is retrieved successfully', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    User::factory()->create();

    collect(array_fill(0, 5, 1))->map(fn() => EmployerJob::factory()->create());

    CandidateJobApplication::factory()->create();

    EmployerJobViewCount::factory()->create();

    EmployerJobViewCount::factory()->create(['employer_job_id' => 2, 'apply_count' => 0]);

    $response = $this->actingAs($user)->get("/v1/employer/dashboard?filterOverview=year");

    expect($response->json()['status'])->toBe('200');

    //dd($response->json());
});
