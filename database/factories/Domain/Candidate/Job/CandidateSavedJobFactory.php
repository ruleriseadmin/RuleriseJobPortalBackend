<?php

namespace Database\Factories\Domain\Candidate\Job;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Candidate\Job\CandidateSavedJob>
 */
class CandidateSavedJobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'job_ids' => [1],
        ];
    }
}
