<?php

namespace Database\Factories\Domain\Shared\Subscription;

use App\Models\Domain\Shared\Subscription\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Domain\Shared\Subscription\SubscriptionPlan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Shared\SubscriptionUsage>
 */
class SubscriptionUsageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $plan = SubscriptionPlan::first();

        $subscription = Subscription::first();

        return [
            'uuid' => str()->uuid(),
            'subscription_id' => $subscription->id,
            'quota' => $plan->quota,
            'quota_remaining' => $plan->quota,
            'quota_used' => 0,
            //'meta',
        ];
    }
}
