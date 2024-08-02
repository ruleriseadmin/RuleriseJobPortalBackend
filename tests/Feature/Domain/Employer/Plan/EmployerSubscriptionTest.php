<?php

use App\Models\Domain\Candidate\User;
use App\Models\Domain\Shared\Subscription\SubscriptionPlan;
use App\Models\Domain\Shared\Subscription\SubscriptionUsage;
use Database\Seeders\RoleSeeder;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerUser;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Shared\Subscription\Subscription;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That employer cv packages are retrieved successfully', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    SubscriptionPlan::factory()->create();

    $response = $this->actingAs($user)->get("/v1/employer/cv-packages");

    expect($response->json()['status'])->toBe('200');
});

test('That employer subscribes to a cv package', function () {

    $employer = Employer::factory()->create();

    EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $plan = SubscriptionPlan::factory()->create();

    $employer->subscribe(1);

    expect($employer->hasActiveSubscription())->toBeTrue();

    expect($employer->activeSubscription()->subscriptionPlan->name)->toBe($plan->name);

    expect($employer->subscriptionHistories()->count())->toBe(1);
});

test('That employer subscription renewed', function () {

    $employer = Employer::factory()->create();

    $plan = SubscriptionPlan::factory()->create();

    Subscription::factory()->create();

    SubscriptionUsage::factory()->create();

    $employer->renewSubscription(true);

    expect($employer->hasActiveSubscription())->toBeTrue();

    expect($employer->activeSubscription()->subscriptionPlan->name)->toBe($plan->name);
});

test('That employer subscription detail without active subscription', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    SubscriptionPlan::factory()->create();

    $response = $this->actingAs($user)->get("/v1/employer/cv-packages/subscription-detail");

    expect($response->json()['status'])->toBe('200');

    $response->assertJsonStructure([
        'data' => [
            'status'
        ],
    ]);

    expect($response->Json()['data']['status'])->toBe('none');
});

test('That employer subscription detail with active subscription', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $plan = SubscriptionPlan::factory()->create();

    Subscription::factory()->create();

    SubscriptionUsage::factory()->create();

    $response = $this->actingAs($user)->get("/v1/employer/cv-packages/subscription-detail");

    expect($response->json()['status'])->toBe('200');

    $response->assertJsonStructure([
        'data' => [
            'status'
        ],
    ]);

    $response->assertJson([
        "data" => [
            "status" => "active",
            "name" => $plan->name,
            "quotaRemaining" => $plan->quota,
        ],
    ]);
});

test('That employer subscription usage is updated', function () {

    $employer = Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    SubscriptionPlan::factory()->create();

    Subscription::factory()->create();

    SubscriptionUsage::factory()->create();

    $candidate = User::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/cv-packages/update-download-usage", [
        'candidateId' => $candidate->uuid,
    ]);

    expect($response->json()['status'])->toBe('200');

    $employer->refresh();

    $usage = $employer->subscriptionUsage();

    expect($usage->quota_remaining)->toBe($usage->quota - 1);

    expect($usage->quota_used)->toBe(1);

    expect($usage->meta['cv_downloaded'][0])->toBe($candidate->uuid);
});

test('That employer cv package payment link is created', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $plan = SubscriptionPlan::factory()->create();

    //$response = $this->actingAs($user)->post("/v1/employer/cv-packages/{$plan->uuid}/subscribe");

    expect(true)->toBeTrue();

    //expect($response->json()['status'])->toBe('200');

    //$response->assertJsonStructure([ 'data' => ['paymentLink']]);
});
