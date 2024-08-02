<?php

namespace Database\Factories\Domain\Shared\Subscription;

use App\Models\Domain\Employer\Employer;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Domain\Shared\Subscription\SubscriptionPlan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Shared\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $plan = SubscriptionPlan::first();

        match ( $plan->interval ){
            'day' => $period = 'addDays',
            default => $period = null,
        };

        $duration = (int) $plan->duration;

        return [
            'uuid' => str()->uuid(),
            'subscription_plan_id' => $plan->id,
            'subscribable_id' => '1',
            'subscribable_type' => Employer::class,
            'active' => true,
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->$period($duration),
        ];
    }
}
