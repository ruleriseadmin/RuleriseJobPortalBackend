<?php

namespace Database\Factories\Domain\Candidate;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Candidate\CandidateQualification>
 */
class CandidateQualificationFactory extends Factory
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
            'highest_qualification' => 'Bsc. Computer Science',
            'year_of_experience' => '1',
            'prefer_job_industry' => 'Information Technology',
            'available_to_work' => 'yes',
            'skills' => ['php', 'laravel'],
            'career_level' => 'junior',
            'functional_areas' => 'IT',
        ];
    }
}
