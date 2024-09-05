<?php

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Employer\EmployerUser;
use App\Models\Domain\Employer\Job\CandidateJobPool;
use App\Models\Domain\Shared\Job\JobCategories;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That employer job is retrieved successfully', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    EmployerJob::factory()->create();

    $response = $this->actingAs($user)->get("/v1/employer/job");

    expect($response->json()['status'])->toBe('200');

    $response->assertJsonStructure([
        'data' => [
            'totalJobs',
            'totalOpenJobs',
            'totalClosedJobs',
            'jobs' => [
                'items' => ['*' => [
                    'uuid',
                    'title',
                    'summary',
                    'description',
                    'jobType',
                    'employmentType',
                    'salary',
                    'easyApply',
                    'emailApply',
                    'active',
                    'requiredSkills',
                    'location',
                    'yearsExperience',
                    'salary',
                ]]
            ],
        ],
    ]);
});

test('That employer single job is retrieved successfully', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $job = EmployerJob::factory()->create();

    CandidateJobPool::factory()->create();

    $response = $this->actingAs($user)->get("/v1/employer/job/{$job->uuid}");

    expect($response->json()['status'])->toBe('200');

    $response->assertJsonStructure([
        'data' => [
            'uuid',
            'title',
            'summary',
            'description',
            'jobType',
            'employmentType',
            'salary',
            'easyApply',
            'emailApply',
            'active',
            'requiredSkills',
            'location',
            'yearsExperience',
            'salary',
            'status',
        ],
    ]);
});

test('That employer created job', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $category = JobCategories::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/job", [
        'title' => 'Software Engineer',
        'summary' => 'job summary',
        'description' => 'quick job description',
        'jobType' => 'full-time',
        'employmentType' => 'full-time',
        'jobIndustry' => 'IT',
        'location' => 'Lagos',
        'yearsExperience' => '2',
        'salary' => '10000',
        'salaryPaymentMode' => 'monthly',
        'easyApply' => true,
        'emailApply' => false,
        'requiredSkills' => ['php', 'javascript'],
        'categoryId' => $category->uuid,
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($response['data']['title'])->toBe('Software Engineer');

    expect(EmployerJob::count())->toBe(1);
});

test('That employer created job as draft', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $category = JobCategories::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/job", [
        'title' => 'Software Engineer',
        'summary' => 'job summary',
        'description' => 'quick job description',
        'jobType' => 'full-time',
        'employmentType' => 'full-time',
        'jobIndustry' => 'IT',
        'location' => 'Lagos',
        'yearsExperience' => '2',
        'salary' => '10000',
        'salaryPaymentMode' => 'monthly',
        'easyApply' => true,
        'emailApply' => false,
        'isDraft' => true,
        'requiredSkills' => ['php', 'javascript'],
        'active' => false,
        'categoryId' => $category->uuid,
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($response['data']['title'])->toBe('Software Engineer');

    expect(EmployerJob::first()->active)->toBeFalse();

    expect(EmployerJob::first()->is_draft)->toBeTrue();

    expect(EmployerJob::first()->status)->toBe('draft');

    expect(EmployerJob::count())->toBe(1);
});

test('That employer created job as published', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $category = JobCategories::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/job", [
        'title' => 'Software Engineer',
        'summary' => 'job summary',
        'description' => 'quick job description',
        'jobType' => 'full-time',
        'employmentType' => 'full-time',
        //'jobIndustry' => 'IT',
        'location' => 'Lagos',
        'yearsExperience' => '2',
        'salary' => '10000',
        'salaryPaymentMode' => 'monthly',
        'easyApply' => true,
        'emailApply' => true,
        'requiredSkills' => ['php', 'javascript'],
        'active' => true,
        'isDraft' => false,
        'categoryId' => $category->uuid,
        'emailToApply' => 'employer@example.com'
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($response['data']['title'])->toBe('Software Engineer');

    expect(EmployerJob::first()->active)->toBeTrue();

    expect(EmployerJob::first()->status)->toBe('open');

    expect(EmployerJob::count())->toBe(1);
});

test('That employer updated job', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $job = EmployerJob::factory()->create();

    $category = JobCategories::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/job/update", [
        'uuid' => $job->uuid,
        'title' => 'Software Developer',
        'summary' => 'job summary',
        'description' => 'quick job description',
        'categoryId' => $category->uuid,
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(EmployerJob::first()->title)->toBe('Software Developer');
});

test('That employer deleted job', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $job = EmployerJob::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/job/{$job->uuid}/delete");

    expect($response->json()['status'])->toBe('200');

    expect(EmployerJob::count())->toBe(0);

    expect(EmployerJob::onlyTrashed()->count())->toBe(1);
});

test('That employer open / close job', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $job = EmployerJob::factory()->create();

    $open = $this->actingAs($user)->post("/v1/employer/job/{$job->uuid}/setOpenClose");

    expect($open->json()['status'])->toBe('200');

    expect($job->refresh()->status)->toBe('closed');

    $closed = $this->actingAs($user)->post("/v1/employer/job/{$job->uuid}/setOpenClose");

    expect($closed->json()['status'])->toBe('200');

    expect($job->refresh()->status)->toBe('open');
});

test('That employer publish job', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $job = EmployerJob::factory()->create();

    $open = $this->actingAs($user)->post("/v1/employer/job/{$job->uuid}/publishJob");

    expect($open->json()['status'])->toBe('200');

    expect($job->refresh()->status)->toBe('open');

    expect($job->refresh()->is_draft)->toBeFalse();
});
