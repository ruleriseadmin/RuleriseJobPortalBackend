<?php

namespace App\Actions\Domain\Employer\Plan;

use Exception;
use Stripe\Stripe;
use Stripe\PaymentLink;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Shared\SubscriptionPlan;

class CreatePaymentLinkAction
{
    public function execute(SubscriptionPlan $plan): ?string
    {
        try{
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentLink = PaymentLink::create([
                'line_items' => [
                    [
                        'price' => $plan->plan_id,
                        'quantity' => 1,
                      ]
                ],
            ]);

            //@todo create transaction
    }catch(Exception $ex){
        Log::error('Error @ CreatePaymentLinkAction: ' . $ex->getMessage());
        return null;
    }

        return $paymentLink->url;
    }
}
