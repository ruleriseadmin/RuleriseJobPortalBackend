<?php

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerJob;

test('That front page is retrieved successfully', function () {
    collect(array_fill(0, 5, 1))->map(fn() => Employer::factory()->create());

    collect(array_fill(0, 5, 1))->map(fn() => EmployerJob::factory()->create());

    $response = $this->get('v1/front-page');

    expect($response->json()['status'])->toBe('200');
});
