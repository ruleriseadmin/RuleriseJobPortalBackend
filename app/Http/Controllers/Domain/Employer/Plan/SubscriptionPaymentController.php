<?php

namespace App\Http\Controllers\Domain\Employer\Plan;

use App\Actions\Domain\Shared\Subscription\ProcessSubscriptionPaymentWebhook;
use App\Http\Controllers\Domain\Employer\BaseController;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Models\Domain\Shared\Subscription\SubscriptionPlan;
use App\Actions\Domain\Shared\Plan\CreatePaymentLinkAction;
use App\Http\Resources\Domain\Shared\Subscription\SubscriptionPackagesResource;

class SubscriptionPaymentController extends BaseController
{
    public function subscriptionList(): JsonResponse
    {
        $plans = SubscriptionPlan::query()->where('active', true)->get();

        return ApiReturnResponse::success(SubscriptionPackagesResource::collection($plans));
    }

    public function createPaymentLink(string $uuid): JsonResponse
    {
        $plan = SubscriptionPlan::whereUuid($uuid);

        if (!$plan) {
            return ApiReturnResponse::failed('Plan not found');
        }

        if ( ! $plan->active ) return ApiReturnResponse::failed('Plan not active');

        $paymentLink = (new CreatePaymentLinkAction)->execute($this->employer, $plan);

        return $paymentLink
            ? ApiReturnResponse::success(['paymentLink' => $paymentLink])
            : ApiReturnResponse::failed();
    }

    public function verifySubscription()
    {
        //@todo update

        if ( $this->employer->hasActiveSubscription() ) return ApiReturnResponse::failed();

        $subscriptionTransaction = $this->employer->subscriptionTransactions()->latest();

        (new ProcessSubscriptionPaymentWebhook)->execute($subscriptionTransaction->reference);

        return ApiReturnResponse::success();
    }
}
