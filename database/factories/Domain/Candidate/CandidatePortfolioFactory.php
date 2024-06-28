<?php

namespace Database\Factories\Domain\Candidate;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Candidate\CandidatePortfolio>
 */
class CandidatePortfolioFactory extends Factory
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
            'linkedin' => $this->faker->url(),
            'twitter' => $this->faker->url(),
            'github' => $this->faker->url(),
            'portfolio_url' => $this->faker->url(),
        ];
    }
}
