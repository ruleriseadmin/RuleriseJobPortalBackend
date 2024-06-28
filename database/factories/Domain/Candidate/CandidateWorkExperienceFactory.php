<?php

namespace Database\Factories\Domain\Candidate;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Candidate\CandidateWorkExperience>
 */
class CandidateWorkExperienceFactory extends Factory
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
            'user_id' => 1,
            'role_title' => $this->faker->jobTitle,
            'company_name' => $this->faker->company,
            'start_date' => '2020-01-01',
            'end_date' => '2021-01-01',
        ];
    }
}
