<?php

namespace Database\Factories\Domain\Candidate;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Candidate\CandidateCredential>
 */
class CandidateCredentialFactory extends Factory
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
            'name' => 'Driver license',
            'type' => 'license',
            'date_issued' => '2020-01-01',
        ];
    }
}
