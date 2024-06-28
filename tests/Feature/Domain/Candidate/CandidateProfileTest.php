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

    $workExperiences = CandidateWorkExperience::factory()->create();

    $qualifications = CandidateQualification::factory()->create();

    $portfolio = CandidatePortfolio::factory()->create();

    $languages = CandidateLanguage::factory()->create();

    $educationHistories = CandidateEducationHistory::factory()->create();

    $credentials = CandidateCredential::factory()->create();


    $locationProvince = 'Abuja';
    $mobileCountryCode = '234';
    $mobileNumber = '123456789';
    $gender = 'male';
    $yearOfExperience = '2';
    $skills = ['python'];
    $preferJobIndustry = 'training';
    $dob = '1998-01-01';
    $jobTitle = 'Technician';
    $functionalAreas = 'Electrical';
    $profileSummary = 'An experienced engineer';
    $careerLevel = 'snr';
    $availableToWork = 'no';
    $highestQualification = 'Bsc';
    $linkedin = 'linkedin';
    $github = 'github';
    $twitter = 'twitter';
    $portfolioUrl = 'portfolio-link';

    $response = $this->actingAs($user)->post("/v1/candidate/update-profile", [
        'email' => $user->email,
        'firstName' => $user->first_name,
        'lastName' => $user->last_name,
        'mobileNumber' => $mobileNumber,
        'mobileCountryCode' => $mobileCountryCode,
        'nationality' => $user->nationality,
        'locationProvince' => $locationProvince,
        'dob' => $dob,
        'jobTitle' => $jobTitle,
        'profileSummary' => $profileSummary,
        'functionalAreas' => $functionalAreas,
        'careerLevel' => $careerLevel,
        'availableToWork' => $availableToWork,
        'highestQualification' =>  $highestQualification,
        'yearOfExperience' => $yearOfExperience,
        'preferJobIndustry' => $preferJobIndustry,
        'skills' => $skills,
        'gender' => $gender,
        'linkedin' => $linkedin,
        'twitter' => $twitter,
        'github' => $github,
        'portfolioUrl' => $portfolioUrl,
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

    expect($response->json()['data']['gender'])->toBe($gender);

    expect($response->json()['data']['dob'])->toBe($dob);

    expect($response->json()['data']['profileSummary'])->toBe($profileSummary);

    expect($response->json()['data']['jobTitle'])->toBe($jobTitle);

    expect($response->json()['data']['qualification']['preferJobIndustry'])->toBe($preferJobIndustry);

    expect($response->json()['data']['qualification']['careerLevel'])->toBe($careerLevel);

    expect($response->json()['data']['qualification']['highestQualification'])->toBe($highestQualification);

    expect($response->json()['data']['qualification']['yearOfExperience'])->toBe($yearOfExperience);

    expect($response->json()['data']['qualification']['skills'][0])->toBe($skills[0]);

    expect(count($response->json()['data']['qualification']['skills']))->toBe(count($skills));

    expect($response->json()['data']['qualification']['functionalAreas'])->toBe($functionalAreas);

    expect($response->json()['data']['qualification']['availableToWork'])->toBe($availableToWork);

    expect($response->json()['data']['portfolio']['linkedin'])->toBe($linkedin);

    expect($response->json()['data']['portfolio']['twitter'])->toBe($twitter);

    expect($response->json()['data']['portfolio']['github'])->toBe($github);

    expect($response->json()['data']['portfolio']['portfolioUrl'])->toBe($portfolioUrl);
});

test('That candidate profile cannot be updated if email exists by another candidate', function () {

    $user = User::factory()->create();

    $secondUser = User::factory()->create();

    $locationProvince = 'Abuja';
    $mobileCountryCode = '234';
    $mobileNumber = '123456789';

    $response = $this->actingAs($user)->post("/v1/candidate/update-profile", [
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

test('That candidate account setting is retrieved successfully', function () {

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get("/v1/candidate/account-setting");

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
});

test('That candidate account setting is updated successfully', function () {

    $user = User::factory()->create();

    $qualifications = CandidateQualification::factory()->create();

    $portfolio = CandidatePortfolio::factory()->create();

    $locationProvince = 'Abuja';
    $mobileCountryCode = '234';
    $mobileNumber = '123456789';

    $response = $this->actingAs($user)->post("/v1/candidate/update-account-setting", [
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

test('That candidate profile is deleted successfully', function () {

    $user = User::factory()->create();

    $response = $this->actingAs($user)->post("/v1/candidate/delete-account");

    expect($response->json()['status'])->toBe('200');

    expect(User::count())->toBe(0);

    expect(User::onlyTrashed()->count())->toBe(1);
});
