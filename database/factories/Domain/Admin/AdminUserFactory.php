<?php

namespace Database\Factories\Domain\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Admin\AdminUser>
 */
class AdminUserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => str()->uuid(),
            'email' => $this->faker->email,
            'password' => Hash::make('password'),
            'first_name' => 'Admin',
            'last_name' => 'User',
        ];
    }
}
