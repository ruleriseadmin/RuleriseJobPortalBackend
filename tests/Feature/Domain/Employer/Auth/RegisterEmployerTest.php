<?php

use App\Models\Domain\Employer\Employer;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('Test that an employer is created', function () {

    $response = $this->post('/v1/employer/auth/register', [
        'email' => 'XVWpF@example.com',
        'password' => 'password001',
        'firstName' => 'John',
        'lastName' => 'Doe',
        'companyName' => 'Rulerise',
        'positionTitle' => 'CEO',
        'officialEmail' => 'offical@example.com',
        'companyIndustry' => 'IT',
        'numberOfEmployees' => '10000',
        'companyFounded' => '2020-01-01',
        'stateCity' => 'Nigeria',
        'address' => '1234 Main St.',
        'benefitOffered' => ['team vacations', 'health insurance'],
        'profileSummary' => 'We are company',
    ]);

    $employer = Employer::first();

    $response->assertStatus(200);

    expect($response->json()['status'])->toBe('200');

    expect($employer->users()->first()->pivot->position_title)->toBe('CEO');

    expect($employer->users()->first()->getCurrentEmployerAccess($employer->id)->hasRole('super_admin'))->toBeTrue();

    expect($employer->benefit_offered[0])->toBe('team vacations');

    expect(count($employer->benefit_offered))->toBe(2);

    expect($employer->profile_summary)->toBe('We are company');

    expect($employer->industry)->toBe('IT');

    expect($employer->founded_at)->toBe('2020-01-01');

    expect($employer->email)->toBe('offical@example.com');

    expect($employer->number_of_employees)->toBe('10000');

    expect(Employer::all()->count())->toBe(1);

    expect($employer->users->count())->toBe(1);
});
