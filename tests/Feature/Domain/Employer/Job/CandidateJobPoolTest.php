<?php

use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Employer\EmployerUser;
use App\Models\Domain\Employer\Job\CandidateJobPool;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That employer list candidate job pool successfully', function () {
    $employer = Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    CandidateJobPool::factory()->create();

    $response = $this->actingAs($user)->get("/v1/employer/candidate-pool");

    expect($response->json()['status'])->toBe('200');

    expect(count($response->json()['data']))->toBe(1);
});

test('That employer list candidate job pool candidates successfully', function () {
    $employer = Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    User::factory()->create();

    $pool = CandidateJobPool::factory()->create();

    $response = $this->actingAs($user)->get("/v1/employer/candidate-pool/{$pool->uuid}/view-candidate");

    expect($response->json()['status'])->toBe('200');
});

test('That employer created candidate job pool', function () {
    $employer = Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/candidate-pool", [
        'name' => 'Pool 1',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($employer->candidatePools->count())->toBe(1);
});

test('That employer attached candidate to candidate job pool', function () {
    $employer = Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $candidate = User::factory()->create();

    $pool = CandidateJobPool::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/candidate-pool/attach-candidate", [
        'candidatePoolIds' => [$pool->uuid],
        'candidateIds' => [$candidate->uuid],
    ]);

    $pool->refresh();

    expect($response->json()['status'])->toBe('200');

    expect(count($pool->candidate_ids))->toBe(2);

    expect(collect($pool->candidate_ids)->first())->toBe($candidate->id);
});

test('That employer attached multiple candidates to candidate job pool', function () {
    $employer = Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $candidate = User::factory()->create();
    $candidateTwo = User::factory()->create();

    $pool = CandidateJobPool::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/candidate-pool/attach-candidate", [
        'candidatePoolIds' => [$pool->uuid],
        'candidateIds' => [$candidate->uuid, $candidateTwo->uuid],
    ]);

    $pool->refresh();

    expect($response->json()['status'])->toBe('200');

    expect(count($pool->candidate_ids))->toBe(3);

    expect($pool->candidate_ids[0])->toBe($candidate->id);

    expect($pool->candidate_ids[2])->toBe($candidateTwo->id);
});

test('That employer attached candidate to multiple candidate job pools', function () {
    $employer = Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $candidate = User::factory()->create();

    Employer::factory()->create();

    $pool = CandidateJobPool::factory()->create();
    $poolTwo = CandidateJobPool::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/candidate-pool/attach-candidate", [
        'candidatePoolIds' => [$pool->uuid, $poolTwo->uuid],
        'candidateIds' => [$candidate->uuid],
    ]);

    $pool->refresh();

    $poolTwo->refresh();

    expect($response->json()['status'])->toBe('200');

    expect(count($pool->candidate_ids))->toBe(2);

    expect($pool->candidate_ids[0])->toBe($candidate->id);

    expect($poolTwo->candidate_ids[0])->toBe($candidate->id);
});

test('That employer attached multiple candidates to multiple candidate job pools', function () {
    $employer = Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $candidate = User::factory()->create();
    $candidateTwo = User::factory()->create();

    $pool = CandidateJobPool::factory()->create();
    $poolTwo = CandidateJobPool::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/candidate-pool/attach-candidate", [
        'candidatePoolIds' => [$pool->uuid, $poolTwo->uuid],
        'candidateIds' => [$candidate->uuid, $candidateTwo->uuid],
    ]);

    $pool->refresh();

    $poolTwo->refresh();

    expect($response->json()['status'])->toBe('200');

    expect(count($pool->candidate_ids))->toBe(3);

    expect($pool->candidate_ids[0])->toBe($candidate->id);

    expect($pool->candidate_ids[2])->toBe($candidateTwo->id);

    expect($poolTwo->candidate_ids[0])->toBe($candidate->id);

    expect($poolTwo->candidate_ids[2])->toBe($candidateTwo->id);
});
