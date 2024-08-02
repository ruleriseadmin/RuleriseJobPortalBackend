<?php

namespace App\Http\Controllers\Domain\Shared\Webhook\Subscription;

use Exception;
use Stripe\Stripe;
use Stripe\Webhook;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Actions\Domain\Shared\Subscription\ProcessSubscriptionPaymentWebhook;
use Illuminate\Support\Facades\Log;

class PaymentSubscriptionWebhookController
{
    public function stripe(Request $request): JsonResponse
    {
        //validate stripe webhook
        Stripe::setApiKey(config('services.stripe.secret'));

        try{
            $event = Webhook::constructEvent(
                payload: $request->getContent(),
                sigHeader: $request->header('Stripe-Signature'),
                secret: config('services.stripe.webhook_secret')
            );
        }catch(Exception $ex){
            Log::error("Error at Stripe webhook: " . $ex->getMessage());
            http_response_code(400);
            ApiReturnResponse::failed('Error verifying webhook signature:');
            exit();
        }

        if ( $event->type != 'checkout.session.completed' ){
            ApiReturnResponse::success('Webhook processed successfully');
            exit();
        }

        (new ProcessSubscriptionPaymentWebhook)->execute($event->data->object->id);

        return ApiReturnResponse::success('Webhook processed successfully');
    }
}
