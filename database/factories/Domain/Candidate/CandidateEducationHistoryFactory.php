<?php

namespace Database\Factories\Domain\Candidate;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Candidate\CandidateEducationHistory>
 */
class CandidateEducationHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => '1',
            'uuid' => $this->faker->uuid,
            'institute_name' => $this->faker->company,
            'course_name' => $this->faker->jobTitle,
            'start_date' => '2020-01-01',
            'end_date' => '2020-01-01',
        ];
    }
}
