<?php

namespace Database\Factories\Domain\Candidate;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Candidate\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'email' => $this->faker->safeEmail(),
            'password' => 'password',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'mobile_number' => '08012345678',
            'mobile_country_code' => $this->faker->countryCode(),
            'nationality' => 'Canada',
            'location_province' => $this->faker->state(),
            'dob' => $this->faker->date(),
            'job_title' => 'Software Developer',
            'gender' => $this->faker->randomElement(['male', 'female']),
            'profile_summary' => $this->faker->sentence(10),
            'email_verified_at' => now(),
        ];
    }
}
