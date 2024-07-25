<?php

namespace App\Http\Controllers\Domain\Employer\Plan;

use App\Http\Resources\Domain\Employer\Plan\SubscriptionPackagesResource;
use App\Models\Domain\Shared\SubscriptionPlan;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Actions\Domain\Employer\Plan\CreatePaymentLinkAction;

class SubscriptionPaymentController
{
    public function subscriptionList(): JsonResponse
    {
        $plans = SubscriptionPlan::query()->where('active', true)->get();

        return ApiReturnResponse::success(SubscriptionPackagesResource::collection($plans));
    }

    public function createPaymentLink(string $uuid): JsonResponse
    {
        $plan = SubscriptionPlan::whereUuid($uuid)->first();

        if (!$plan) {
            return ApiReturnResponse::failed('Plan not found');
        }

        $paymentLink = (new CreatePaymentLinkAction)->execute($plan);

        return $paymentLink
            ? ApiReturnResponse::success(['paymentLink' => $paymentLink])
            : ApiReturnResponse::failed();
    }
}
