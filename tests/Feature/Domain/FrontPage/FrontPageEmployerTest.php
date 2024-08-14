<?php

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerJob;

test('front page list employers', function () {
    collect(array_fill(0, 5, 1))->map(fn() => Employer::factory()->create());

    EmployerJob::factory()->create();

     $response = $this->get("/v1/employers");

     expect($response->json()['status'])->toBe('200');
 });

test('front page show employer', function () {
    $employer = Employer::factory()->create();

    EmployerJob::factory()->create();

    $response = $this->get("/v1/employers/{$employer->uuid}");

    expect($response->json()['status'])->toBe('200');
});
