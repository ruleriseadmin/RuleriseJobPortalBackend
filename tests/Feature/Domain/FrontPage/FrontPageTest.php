<?php

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Shared\Job\JobCategories;

test('That front page is retrieved successfully', function () {
    collect(array_fill(0, 5, 1))->map(fn() => Employer::factory()->create());

    JobCategories::factory()->create();

    collect(array_fill(0, 5, 1))->map(fn() => EmployerJob::factory()->create());

    $response = $this->get('v1/front-page');

    expect($response->json()['status'])->toBe('200');
});

test('That front page latest jobs is retrieved successfully', function () {
    collect(array_fill(0, 5, 1))->map(fn() => Employer::factory()->create());

    JobCategories::factory()->create();

    collect(array_fill(0, 5, 1))->map(fn() => EmployerJob::factory()->create());

    $response = $this->get('v1/latest-jobs');

    expect($response->json()['status'])->toBe('200');
});
