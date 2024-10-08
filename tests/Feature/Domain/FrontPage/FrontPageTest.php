<?php

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Admin\GeneralSetting;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Shared\Job\JobCategories;

test('That front page is retrieved successfully', function () {

    GeneralSetting::factory()->create([
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    collect(array_fill(0, 5, 1))->map(fn() => Employer::factory()->create());

    JobCategories::factory()->create();

    collect(array_fill(0, 5, 1))->map(fn() => EmployerJob::factory()->create());

    $response = $this->get('v1/front-page');

    expect($response->json()['status'])->toBe('200');
});

test('That front page latest jobs is retrieved successfully', function () {

    GeneralSetting::factory()->create([
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    collect(array_fill(0, 5, 1))->map(fn() => Employer::factory()->create());

    JobCategories::factory()->create();

    collect(array_fill(0, 5, 1))->map(fn() => EmployerJob::factory()->create());

    $response = $this->get('v1/latest-jobs');

    expect($response->json()['status'])->toBe('200');
});


test('That front page show single job category is retrieved successfully', function () {

    GeneralSetting::factory()->create([
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    collect(array_fill(0, 5, 1))->map(fn() => Employer::factory()->create());

    $category = JobCategories::factory()->create();

    collect(array_fill(0, 5, 1))->map(fn() => EmployerJob::factory()->create());

    $response = $this->get("v1/job-categories/{$category->uuid}");

    expect($response->json()['status'])->toBe('200');
});

test('That front page show single job is retrieved successfully', function () {
    GeneralSetting::factory()->create([
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    JobCategories::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    $response = $this->get("v1/job/{$job->uuid}");

    expect($response->json()['status'])->toBe('200');
});
