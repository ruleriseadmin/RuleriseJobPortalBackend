<?php

use App\Models\Domain\Candidate\CandidateCredential;
use App\Models\Domain\Candidate\CandidateEducationHistory;
use App\Models\Domain\Candidate\CandidateLanguage;
use App\Models\Domain\Candidate\CandidatePortfolio;
use App\Models\Domain\Candidate\CandidateQualification;
use App\Models\Domain\Candidate\CandidateWorkExperience;
use App\Models\Domain\Candidate\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That candidate profile is retrieved successfully', function () {

    $user = User::factory()->create();

    $workExperiences = CandidateWorkExperience::factory()->create();

    $qualifications = CandidateQualification::factory()->create();

    $portfolio = CandidatePortfolio::factory()->create();

    $languages = CandidateLanguage::factory()->create();

    $educationHistories = CandidateEducationHistory::factory()->create();

    $credentials = CandidateCredential::factory()->create();

    $response = $this->actingAs($user)->get("/v1/candidate/profile");

    expect($response->json()['status'])->toBe('200');

    $response->assertJsonStructure([
        'data' => [
            'uuid',
            'email',
            'firstName',
            'lastName',
            'mobileNumber',
            'mobileCountryCode',
            'nationality',
            'locationProvince',
            'dob',
            'gender',
            'jobTitle',
            'profileSummary',
            'qualification' => [
                'highestQualification',
                'yearOfExperience',
                'preferJobIndustry',
                'availableToWork',
                'skills',
                'careerLevel',
                'functionalAreas',
            ],
            'workExperience' => ['*' => [
                'uuid',
                'roleTitle',
                'companyName',
                'startDate',
                'endDate',
            ]],
            'educationHistory' => ['*' => [
                'uuid',
                'instituteName',
                'courseName',
                'startDate',
                'endDate',
            ]],
            'credentials' => ['*' => [
                'name',
                'type',
                'dateIssued',
            ]],
            'language' => ['*' => [
                'uuid',
                'language',
                'proficiency',
            ]],
            'portfolio' => [
                'linkedin',
                'twitter',
                'github',
                'portfolioUrl',
            ],
        ],
        'message',
    ]);

    expect($response->json()['data']['uuid'])->toBe($user->uuid);

    expect($response->json()['data']['locationProvince'])->toBe($user->location_province);
});

test('That candidate profile is updated successfully', function () {

    $user = User::factory()->create();

    $locationProvince = 'Abuja';
    $mobileCountryCode = '234';
    $mobileNumber = '123456789';

    $response = $this->actingAs($user)->post("/v1/candidate/updateProfile", [
        'email' => $user->email,
        'firstName' => $user->first_name,
        'lastName' => $user->last_name,
        'mobileNumber' => $mobileNumber,
        'mobileCountryCode' => $mobileCountryCode,
        'nationality' => $user->nationality,
        'locationProvince' => $locationProvince,
    ]);

    expect($response->json()['status'])->toBe('200');

    $response->assertJsonStructure([
        'data' => [
            'uuid',
            'email',
            'firstName',
            'lastName',
            'mobileNumber',
            'mobileCountryCode',
            'nationality',
            'locationProvince',
        ],
        'message',
    ]);

    expect($response->json()['data']['uuid'])->toBe($user->uuid);

    expect($response->json()['data']['locationProvince'])->toBe($locationProvince);

    expect($response->json()['data']['mobileNumber'])->toBe($mobileNumber);

    expect($response->json()['data']['mobileCountryCode'])->toBe($mobileCountryCode);
});

test('That candidate profile cannot be updated if email exists by another candidate', function () {

    $user = User::factory()->create();

    $secondUser = User::factory()->create();

    $locationProvince = 'Abuja';
    $mobileCountryCode = '234';
    $mobileNumber = '123456789';

    $response = $this->actingAs($user)->post("/v1/candidate/updateProfile", [
        'email' => $secondUser->email,
        'firstName' => $user->first_name,
        'lastName' => $user->last_name,
        'mobileNumber' => $mobileNumber,
        'mobileCountryCode' => $mobileCountryCode,
        'nationality' => $user->nationality,
        'locationProvince' => $locationProvince,
    ]);

    expect($response->json()['status'])->toBe('payloadValidationError');

    $response->assertJsonStructure([
        'data' => [
            'email' => [],
        ],
        'message',
    ])->assertJson([
        'message' => 'Validation error',
        'data' => [
            'email' => ['Email already exists'],
        ],
    ]);
});

test('That candidate profile is deleted successfully', function () {

    $user = User::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/deleteAccount");

    expect($response->json()['status'])->toBe('200');

    expect(User::count())->toBe(0);

    expect(User::onlyTrashed()->count())->toBe(1);
});
