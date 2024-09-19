<?php

namespace App\Actions\Domain\Shared\Plan;

use Exception;
use Stripe\Stripe;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Shared\Subscription\SubscriptionPlan;
use Illuminate\Database\Eloquent\Model;
use Stripe\Checkout\Session;

class CreatePaymentLinkAction
{
    public function execute(Model $model, SubscriptionPlan $plan): ?string
    {
        try{
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentLink = Session::create([
                'line_items' => [
                    [
                        'price' => $plan->plan_id,
                        'quantity' => 1,
                      ]
                ],
                'success_url' => config('env.employer.success_page_on_subscription'), //@todo change this url
                'mode' => 'subscription',
                //'customer',
            ]);

            //create transaction
            $model->subscriptionTransactions()->create([
                'uuid' => str()->uuid(),
                'reference' => $paymentLink->id,
                'amount' => $plan->amount,
                'currency' => $plan->currency,
                'subscription_plan_id' => $plan->id,
            ]);
    }catch(Exception $ex){
        Log::error('Error @ CreatePaymentLinkAction: ' . $ex->getMessage());
        return null;
    }

        return $paymentLink->url;
    }
}
