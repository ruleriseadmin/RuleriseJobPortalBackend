<?php

namespace Database\Factories\Domain\Shared\Job;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Shared\Job\JobCategories>
 */
class JobCategoriesFactory extends Factory
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
            'name' => $this->faker->word,
            'subcategories' => $this->faker->words(3),
        ];
    }
}
