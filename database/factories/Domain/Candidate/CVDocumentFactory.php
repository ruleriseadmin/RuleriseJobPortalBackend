<?php

namespace Database\Factories\Domain\Candidate;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Candidate\CVDocument>
 */
class CVDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => str()->uuid(),
            'user_id' => 1,
            'cv_document_url' => 'cv/hodkiewicz.deanna@example.net-curriculum-vitae.pdf',
        ];
    }
}
