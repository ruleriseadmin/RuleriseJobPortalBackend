<?php

namespace App\Actions\Domain\Admin\Subscription\SubscriptionPlan;

use Exception;
use Stripe\Plan;
use Stripe\Stripe;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Shared\Subscription\SubscriptionPlan;

class SetPlanActiveAction
{
    public function execute(SubscriptionPlan $plan, bool $active): bool
    {
        try{
            Stripe::setApiKey(config('services.stripe.secret'));

            Plan::update($plan->plan_id, ['active' => $active]);

            $plan->update(['active' => $active]);
        }catch(Exception $ex){
            Log::error("Error @ SetPlanActiveAction: " . $ex->getMessage());
            return false;
        }

        return true;
    }
}
