<?php

namespace Database\Factories\Domain\Employer\Job;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Employer\Job\EmployerJobViewCount>
 */
class EmployerJobViewCountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employer_job_id' => 1,
            'employer_id' => 1,
            'view_count' => 1,
            'apply_count' => 1,
        ];
    }
}
