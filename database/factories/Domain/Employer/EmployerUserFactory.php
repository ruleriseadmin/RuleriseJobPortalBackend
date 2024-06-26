<?php

namespace Database\Factories\Domain\Employer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Employer\EmployerUser>
 */
class EmployerUserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'email' => 'test@example.com',
            'password' => 'password',
        ];
    }
}
