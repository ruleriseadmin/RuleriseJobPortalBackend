<?php

namespace Database\Factories\Domain\Shared;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Shared\SubscriptionPlan>
 */
class SubscriptionPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "uuid" => "da9828b4-1318-40fb-a081-58a884ed9ae4",
            "plan_id" => "plan_QXKXlppUsEan3X",
            "product_id" => "prod_QXKXtcYFivdJBA",
            "name" => "Lite Plan",
            "description" => "Lite Plan cv package",
            "active" => 1,
            "amount" => 100,
            "currency" => "usd",
            "interval" => "day",
            "interval_count" => 15,
            "trial_period_days" => null,
            "number_of_candidate" => 50,
            "duration" => 15,
        ];
    }
}
