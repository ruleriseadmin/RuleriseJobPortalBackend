<?php

namespace App\Actions\Domain\Admin\Subscription\SubscriptionPlan;

use Exception;
use Stripe\Plan;
use Stripe\Stripe;
use Stripe\Product;
use App\Supports\HelperSupport;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Shared\SubscriptionPlan;

class UpdatePlanAction
{
    public function execute(SubscriptionPlan $plan, array $inputs): ?SubscriptionPlan
    {
        try{
            Stripe::setApiKey(config('services.stripe.secret'));
            
            Product::update($plan->product_id, [
                'name' => $inputs['name'],
            ]);

            Plan::update($plan->plan_id, [
                'amount' => $inputs['price'],
                'currency' => 'usd',
                'interval' => $inputs['interval'],
            ]);

            $plan->update(HelperSupport::camel_to_snake($inputs));
        }catch(Exception $ex){
            Log::error("Error @ UpdatePlanAction: " . $ex->getMessage());
            return null;
        }
        return $plan;
    }
}
