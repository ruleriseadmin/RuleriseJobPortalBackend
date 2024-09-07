<?php

use Database\Seeders\RoleSeeder;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Admin\GeneralSetting;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Employer\EmployerUser;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Candidate\Job\CandidateSavedJob;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That candidate filter job as new', function () {

    GeneralSetting::factory()->create([
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    $user = User::factory()->create();

    Employer::factory()->create();

    collect(array_fill(0, 5, 1))->map(fn() => EmployerJob::factory()->create());

    $response = $this->actingAs($user)->get("/v1/candidate/job?type=new&page=1");

    //dd($response->json());

    expect($response->json()['status'])->toBe('200');

    $response->assertJsonStructure([
        'data' => [
            'page',
            'nextPage',
            'hasMorePages',
            'jobs' => ['*' => [
                'title',
                'employmentType',
                'location',
                'salary',
                'employerName',
                'uuid',
                'saved',
            ]],
        ]
    ]);
});

test('That candidate filter job as saved', function () {

    GeneralSetting::factory()->create([
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    $user = User::factory()->create();

    Employer::factory()->create();

    EmployerJob::factory()->create();

    CandidateSavedJob::factory()->create();

    $response = $this->actingAs($user)->get("/v1/candidate/job?type=saved&page=1");

    expect($response->json()['status'])->toBe('200');

    //dd($response->json());

    $response->assertJsonStructure([
        'data' => [
            'page',
            'nextPage',
            'hasMorePages',
            'jobs' => ['*' => [
                'title',
                'employmentType',
                'location',
                'salary',
                'employerName',
                'uuid',
                'saved',
            ]],
        ]
    ]);
});

test('That candidate filter job as applied', function () {

    GeneralSetting::factory()->create([
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    $user = User::factory()->create();

    Employer::factory()->create();

    EmployerJob::factory()->create();

    $application = CandidateJobApplication::factory()->create();

    $application->setStatus('applied');

    $response = $this->actingAs($user)->get("/v1/candidate/job?type=applied&page=1");

    expect($response->json()['status'])->toBe('200');

    //dd($response->json());

    $response->assertJsonStructure([
        'data' => [
            'page',
            'nextPage',
            'hasMorePages',
            'jobs' => ['*' => [
                'title',
                'employmentType',
                'location',
                'salary',
                'employerName',
                'uuid',
                'status',
                'appliedAt',
                'saved',
            ]],
        ]
    ]);
});
