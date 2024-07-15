<?php

namespace Database\Factories\Domain\Employer\Job;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Employer\Job\CandidateJobPool>
 */
class CandidateJobPoolFactory extends Factory
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
            'employer_id' => '1',
            'name' => 'Developer',
            'candidate_ids' => [1],
        ];
    }
}
