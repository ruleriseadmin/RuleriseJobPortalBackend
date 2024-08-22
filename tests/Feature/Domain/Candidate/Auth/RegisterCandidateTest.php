<?php

use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\Employer;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('Test that a candidate is created', function () {

    $response = $this->post('/v1/candidate/auth/register', [
        'email' => 'XVWpF@example.com',
        'password' => 'password001',
        'firstName' => 'John',
        'lastName' => 'Doe',
        'mobileNumber' => '08012345678',
        'mobileCountryCode' => '234',
        'nationality' => 'Nigeria',
        'locationProvince' => 'Lagos',
        'yearOfExperience' => '1',
        'highestQualification' => 'Bsc. Computer Science',
        'preferJobIndustry' => 'Information Technology',
        'availableToWork' => true,
        'skills' => ['php', 'laravel'],
    ]);

    $candidate = User::first();

    $response->assertStatus(200);

    expect($response->json()['status'])->toBe('200');

    expect($candidate->first_name)->toBe('John');

    expect($candidate->qualification->exists())->toBeTrue();

    expect($candidate->qualification->year_of_experience)->toBe('1');

    expect($candidate->qualification->skills[0])->toBe('php');

    expect(count($candidate->qualification->skills))->toBe(2);

    expect($candidate->email_verified_token)->toBeString();
});

test('That candidate send resent verification email', function () {

    $user = User::factory()->create();

    $response = $this->post("/v1/candidate/auth/resendEmailVerification/{$user->email}");

    expect($response->json()['status'])->toBe('200');

    expect($user->refresh()->email_verified_token)->toBeString();
});
