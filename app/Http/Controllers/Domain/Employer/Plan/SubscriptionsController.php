<?php

namespace App\Http\Controllers\Domain\Employer\Plan;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Domain\Employer\BaseController;
use App\Actions\Domain\Employer\Subscription\SetSubscriptionUsageAction;
use App\Http\Requests\Domain\Employer\CVPackage\UpdateCVDownloadUsageRequest;
use App\Http\Resources\Domain\Shared\Subscription\SubscriptionDetailResource;

class SubscriptionsController extends BaseController
{
    public function subscriptionInformation(): JsonResponse
    {
        return ApiReturnResponse::success(new SubscriptionDetailResource($this->employer));
    }

    public function updateCVDownloadUsage(UpdateCVDownloadUsageRequest $request)
    {
        return (new SetSubscriptionUsageAction)->execute($this->employer, $request->input('candidateId'))
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
