<?php

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerJob;

test('That front page search jobs successfully', function () {
    collect(array_fill(0, 5, 1))->map(fn() => Employer::factory()->create());

    collect(array_fill(0, 5, 1))->map(fn() => EmployerJob::factory()->create());

    $response = $this->get('v1/search-jobs?title=engineer');

    expect($response->json()['status'])->toBe('200');
});


test('That front page get latest jobs successfully', function () {
    collect(array_fill(0, 5, 1))->map(fn() => Employer::factory()->create());

    collect(array_fill(0, 5, 1))->map(fn() => EmployerJob::factory()->create());

    $response = $this->get('v1/latest-jobs');

    expect($response->json()['status'])->toBe('200');
});
