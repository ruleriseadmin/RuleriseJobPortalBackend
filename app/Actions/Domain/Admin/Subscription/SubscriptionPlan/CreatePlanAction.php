<?php

namespace App\Actions\Domain\Admin\Subscription\SubscriptionPlan;

use Exception;
use Stripe\Plan;
use Stripe\Product;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Shared\Subscription\SubscriptionPlan;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Subscription;

class CreatePlanAction
{
    public function execute(array $inputs): ?SubscriptionPlan
    {
        try{
            Stripe::setApiKey(config('services.stripe.secret'));

            $stripeProduct = Product::create([
                'name' => $inputs['name'],
            ]);

            $stripePlan = Plan::create([
                'product' => $stripeProduct['id'],
                'amount' => $inputs['price'],
                'currency' => 'usd',
                'interval' => $inputs['interval'],
                'interval_count' => $inputs['duration'],
            ]);

            $description = "{$inputs['name']} cv package";

            $plan = SubscriptionPlan::create([
                'uuid' => str()->uuid(),
                'plan_id' => $stripePlan->id,
                'product_id' => $stripeProduct->id,
                'name' => $inputs['name'],
                'description' => $description,
                'active' => true,
                'amount' => $inputs['price'],
                'currency' => 'usd',
                'interval' => $inputs['interval'],
                'interval_count' => $inputs['duration'],
                'trial_period_days' => null,
                'quota' => $inputs['numberOfCandidate'],
            ]);
        }catch(Exception $ex){
            Log::error("Error @ CreatePlanAction: " . $ex->getMessage());
            return null;
        }

        return $plan;
    }
}
