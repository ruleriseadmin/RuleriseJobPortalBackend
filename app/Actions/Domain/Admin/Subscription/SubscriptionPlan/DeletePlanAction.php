<?php

namespace App\Actions\Domain\Admin\Subscription\SubscriptionPlan;

use Exception;
use Stripe\Plan;
use Stripe\Stripe;
use Stripe\Product;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Shared\Subscription\SubscriptionPlan;

class DeletePlanAction
{
    public function execute(SubscriptionPlan $plan): bool
    {
        try{
            Stripe::setApiKey(config('services.stripe.secret'));

            //(new Plan($plan->plan_id))->delete();

            (new Product($plan->product_id))->delete();

            $action = $plan->delete();
        }catch(Exception $ex){
            Log::error("Error @ DeletePlanAction: " . $ex->getMessage());
            return false;
        }
        return $action;
    }
}
