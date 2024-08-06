<?php

namespace Database\Factories\Domain\Employer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Employer\Job>
 */
class EmployerJobFactory extends Factory
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
            'employer_id' => 1,
            'title' => 'Software Engineer',
            'summary' => $this->faker->paragraphs(3, true),
            'description' => $this->faker->paragraphs(10, true),
            'job_type' => 'full-time',
            'employment_type' => 'remote',
            'job_industry' => $this->faker->word,
            'location' => $this->faker->city,
            'years_experience' => $this->faker->numberBetween(1, 10),
            'salary' => $this->faker->randomFloat(2, 20000, 100000),
            'easy_apply' => $this->faker->boolean(),
            'email_apply' => $this->faker->boolean(),
            'required_skills' => $this->faker->sentence(3),
            'active' => true,
        ];
    }
}
