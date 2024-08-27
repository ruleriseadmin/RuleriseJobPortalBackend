<?php

use App\Models\Domain\Candidate\User;

test('That front page candidate profile is retrieved successfully', function () {

    $candidate = User::factory()->create();

    $response = $this->get("v1/candidate-profile/{$candidate->uuid}");

    expect($response->json()['status'])->toBe('200');
});
