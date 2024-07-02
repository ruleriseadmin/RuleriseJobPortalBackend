<?php

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Employer\EmployerUser;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That employer created job', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

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
        'easyApply' => true,
        'emailApply' => false,
        'requiredSkills' => ['php', 'javascript'],
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($response['data']['title'])->toBe('Software Engineer');

    expect(EmployerJob::count())->toBe(1);
});


test('That employer created job as draft', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

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
        'easyApply' => true,
        'emailApply' => false,
        'requiredSkills' => ['php', 'javascript'],
        'active' => false,
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($response['data']['title'])->toBe('Software Engineer');

    expect(EmployerJob::first()->active)->toBeFalse();

    expect(EmployerJob::count())->toBe(1);
});

test('That employer created job as published', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

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
        'easyApply' => true,
        'emailApply' => false,
        'requiredSkills' => ['php', 'javascript'],
        'active' => true,
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($response['data']['title'])->toBe('Software Engineer');

    expect(EmployerJob::first()->active)->toBeTrue();

    expect(EmployerJob::count())->toBe(1);
});

test('That employer updated job', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $job = EmployerJob::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/job/update", [
        'uuid' => $job->uuid,
        'title' => 'Software Developer',
        'summary' => 'job summary',
        'description' => 'quick job description',
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
