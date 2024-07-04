<?php

namespace Database\Factories\Domain\Employer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Employer\Employer>
 */
class EmployerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'email' => 'offical@example.com',
            'company_name' => 'Amazon Ontario',
            'industry' => 'IT',
            'number_of_employees' => '10000',
            'founded_at' => '2020-01-01',
            'state_city' => 'Nigeria',
            'address' => '1234 Main St.',
            'benefit_offered' => ['team vacations', 'health insurance'],
            'profile_summary' => 'We are company',
        ];
    }
}
