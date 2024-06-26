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
    ]);

    $employer = Employer::first();

    $response->assertStatus(200);

    expect($response->json()['status'])->toBe('200');

    expect($employer->users()->first()->pivot->position_title)->toBe('CEO');

    expect($employer->users()->first()->getCurrentEmployerAccess($employer->id)->hasRole('super_admin'))->toBeTrue();

    expect(Employer::all()->count())->toBe(1);

    expect($employer->users->count())->toBe(1);
});
