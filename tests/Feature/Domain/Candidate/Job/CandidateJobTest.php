<?php

use Illuminate\Support\Carbon;
use Database\Seeders\RoleSeeder;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Admin\GeneralSetting;
use App\Models\Domain\Candidate\CVDocument;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Employer\EmployerUser;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Candidate\Job\CandidateSavedJob;
use App\Models\Domain\Employer\Job\EmployerJobViewCount;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That candidate views a job', function () {

    GeneralSetting::factory()->create([
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    $user = User::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    $response = $this->actingAs($user)->get("/v1/candidate/job/{$job->uuid}/detail");

    expect($response->json()['status'])->toBe('200');
});

test('That candidate views a job and job view increments', function () {

    GeneralSetting::factory()->create([
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    $user = User::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    $response = $this->actingAs($user)->get("/v1/candidate/job/{$job->uuid}/detail");

    expect($response->json()['status'])->toBe('200');

    expect($job->jobViewCounts()->count())->toBe(1);
});

test('That candidate views a job and job view increments and updates', function () {

    GeneralSetting::factory()->create([
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    $user = User::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    $jobCount = EmployerJobViewCount::factory()->create([
        'created_at' => Carbon::now()->addMinute(),
    ]);

    $response = $this->actingAs($user)->get("/v1/candidate/job/{$job->uuid}/detail");

   expect($response->json()['status'])->toBe('200');

    expect($job->jobViewCounts()->count())->toBe(1);

    expect($jobCount->refresh()->view_count)->toBe(2);
});

test('That candidate saved a job', function () {

    $user = User::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/job/{$job->uuid}/saveJob");

    expect($response->json()['status'])->toBe('200');

    expect($user->savedJobs->job_ids[0])->toBe(1);
});

test('That candidate unsaved a job', function () {

    $user = User::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    CandidateSavedJob::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/job/{$job->uuid}/saveJob");

    expect($response->json()['status'])->toBe('200');

    expect(count($user->savedJobs->job_ids))->toBe(0);
});

test('That candidate applied for a job', function () {

    GeneralSetting::factory()->create([
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    $user = User::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/job/applyJob", [
        'applyVia' => 'profile_cv',
        'jobId' => $job->uuid,
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($user->jobApplications->count())->toBe(1);

    expect($user->jobApplications->first()->status())->toBe('unsorted');

    expect($job->jobViewCounts()->first()->apply_count)->toBe(1);
});

test('That candidate cannot apply for already applied job', function () {

    GeneralSetting::factory()->create([
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    $user = User::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    CandidateJobApplication::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/job/applyJob", [
        'applyVia' => 'profile_cv',
        'jobId' => $job->uuid,
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($user->jobApplications->count())->toBe(1);

    expect($user->jobApplications->count())->toBe(1);
});

test('That candidate applied for a job with cv', function () {

    GeneralSetting::factory()->create([
        'name' => 'default_currency',
        'value' => 'NGN',
    ]);

    $user = User::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    $cv = CVDocument::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/job/applyJob", [
        'applyVia' => 'custom_cv',
        'jobId' => $job->uuid,
        'cvId' => $cv->uuid,
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($user->jobApplications->count())->toBe(1);

    expect($user->jobApplications->first()->status())->toBe('unsorted');

    expect($user->jobApplications->first()->cv_url)->toBe('1');
});

test('That candidate views similar job', function () {

    GeneralSetting::factory()->create([
    'name' => 'default_currency',
    'value' => 'NGN',
    ]);

    $user = User::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    collect(array_fill(0, 5, 1))->map(fn() => EmployerJob::factory()->create());

    $response = $this->actingAs($user)->get("/v1/candidate/job/{$job->uuid}/similarJobs");

    expect($response->json()['status'])->toBe('200');
});

test('That candidate report job', function () {

    GeneralSetting::factory()->create([
    'name' => 'default_currency',
    'value' => 'NGN',
    ]);

    $user = User::factory()->create();

    Employer::factory()->create();

    $job = EmployerJob::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/job/{$job->uuid}/reportJob", [
        'reason' => 'Fake Job posting'
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($response->json()['data']['reported'])->toBe(true);
});
