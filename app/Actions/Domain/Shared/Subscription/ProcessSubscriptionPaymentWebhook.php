<?php

namespace App\Actions\Domain\Shared\Subscription;

use App\Models\Domain\Shared\Subscription\SubscriptionTransaction;

class ProcessSubscriptionPaymentWebhook
{
    public function execute(string $transactionReference)
    {
        //get transaction
        $transaction = SubscriptionTransaction::whereReference($transactionReference);

        if ( ! $transaction ) return;

        //get model
        $model = $transaction->subscribable;

        //get plan id
        $plan = $transaction->subscriptionPlan;

        if ( ($transaction->meta['is_renewal'] ?? false) ){
            (new RenewSubscriptionAction)->execute($model);
            return;
        }

        (new CreateSubscriptionAction)->execute($model, $plan->id);
    }
}
