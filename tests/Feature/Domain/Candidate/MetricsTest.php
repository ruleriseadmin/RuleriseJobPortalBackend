<?php

use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Admin\GeneralSetting;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Employer\EmployerUser;

describe('MetricsTest', function () {
   it('That candidate see metrics', function () {
        $user = User::factory()->create();

        GeneralSetting::factory()->create([
            'name' => 'default_currency',
            'value' => 'NGN',
        ]);

        Employer::factory()->create();
        $employerUser = EmployerUser::factory()->create();
        EmployerAccess::factory()->create();

        $this->actingAs($employerUser)->get("/v1/employer/candidate/{$user->uuid}");

        collect(array_fill(0, 5, 1))->map(fn() => EmployerJob::factory()->create());

        CandidateJobApplication::factory()->create();

        $response = $this->actingAs($user)->get('/v1/candidate/metrics');

        expect($response->json()['status'])->toBe('200');

        expect($response->json()['data']['jobAppliedCountLast30Days'])->toBe(1);

        expect($response->json()['data']['profileViewCountLast30Days'])->toBe(1);
    });
});

