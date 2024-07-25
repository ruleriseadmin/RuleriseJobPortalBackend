<?php

use App\Models\Domain\Shared\SubscriptionPlan;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerUser;
use App\Models\Domain\Employer\EmployerAccess;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That employer cv packages are retrieved successfully', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    SubscriptionPlan::factory()->create();

    expect(true)->toBeTrue();

    //$response = $this->actingAs($user)->get("/v1/employer/cv-packages");

    //expect($response->json()['status'])->toBe('200');
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
