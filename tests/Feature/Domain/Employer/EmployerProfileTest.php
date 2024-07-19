<?php

use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerUser;
use App\Models\Domain\Employer\EmployerAccess;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That employer account is retrieved successfully', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $response = $this->actingAs($user)->get("/v1/employer/profile");

    expect($response->json()['status'])->toBe('200');
});

test('That employer account profile is updated successfully', function () {

    $employer = Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/profile", [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'companyName' => 'Rulerise',
        'positionTitle' => 'CEO',
        'officialEmail' => 'email@example.com',
        'companyIndustry' => 'IT',
        'numberOfEmployees' => '10000',
        'companyFounded' => '2020-01-01',
        'stateCity' => 'Nigeria',
        'address' => '1234 Main St.',
        'benefitOffered' => ['paid leave'],
        'profileSummary' => 'company information',
    ]);

    $employer->refresh();

    expect($response->json()['status'])->toBe('200');

    expect($employer->email)->toBe('email@example.com');

    expect($employer->profile_summary)->toBe('company information');

    expect(count($employer->benefit_offered))->toBe(1);

    expect($employer->benefit_offered[0])->toBe('paid leave');
});

test('That employer company name update does not match existing company', function () {

    $employer = Employer::factory()->create();

    $companyTwo = Employer::factory()->create();

    $companyTwo->update(['company_name' => 'Rulerise Inc']);

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/profile", [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'companyName' => 'Rulerise Inc',
        'positionTitle' => 'CEO',
        'officialEmail' => 'email@example.com',
        'companyIndustry' => 'IT',
        'numberOfEmployees' => '10000',
        'companyFounded' => '2020-01-01',
        'stateCity' => 'Nigeria',
        'address' => '1234 Main St.',
        'benefitOffered' => ['paid leave'],
        'profileSummary' => 'company information',
    ]);

    expect($response->json()['status'])->toBe('payloadValidationError');
});

test('That employer account is deleted', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/profile/delete-account");

    expect($response->json()['status'])->toBe('200');

    expect(Employer::count())->toBe(0);

    expect(Employer::onlyTrashed()->count())->toBe(1);

    expect(EmployerUser::count())->toBe(0);

    expect(EmployerUser::onlyTrashed()->count())->toBe(1);
});

test('That employer account password is changed successfully', function () {

    Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    $user['password'] = Hash::make('password1234');

    EmployerAccess::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/profile/change-password", [
        'currentPassword' => 'password1234',
        'password' => 'password12345',
        'passwordConfirmation' => 'password12345',
    ]);

    $user->refresh();

    expect($response->json()['status'])->toBe('200');

    expect(Hash::check('password12345', $user->password))->toBeTrue();
});
