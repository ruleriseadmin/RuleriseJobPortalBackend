<?php

namespace App\Http\Controllers\Domain\Admin\SubscriptionPlan;

use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Controller;
use App\Models\Domain\Shared\Subscription\SubscriptionPlan;
use App\Http\Requests\Domain\Admin\Subscription\Plan\SetActiveRequest;
use App\Http\Requests\Domain\Admin\Subscription\Plan\StorePlanRequest;
use App\Actions\Domain\Admin\Subscription\SubscriptionPlan\CreatePlanAction;
use App\Actions\Domain\Admin\Subscription\SubscriptionPlan\DeletePlanAction;
use App\Actions\Domain\Admin\Subscription\SubscriptionPlan\UpdatePlanAction;
use App\Actions\Domain\Admin\Subscription\SubscriptionPlan\SetPlanActiveAction;

class SubscriptionPlansController extends Controller
{
    public function index()
    {
        //
    }

    public function store(StorePlanRequest $request): JsonResponse
    {
        $plan = (new CreatePlanAction)->execute($request->input());

        return $plan
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function show(string $uuid)
    {
        //
    }

    public function update(StorePlanRequest $request): JsonResponse
    {
        $plan = SubscriptionPlan::whereUuid($request->input('planId'));

        if ( ! $plan ) return ApiReturnResponse::notFound('Plan not found');

        return (new UpdatePlanAction)->execute($plan, $request->input())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function destroy(string $uuid): JsonResponse
    {
        $plan = SubscriptionPlan::whereUuid($uuid);

        if ( ! $plan ) return ApiReturnResponse::notFound('Plan not found');

        return (new DeletePlanAction)->execute($plan)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function setActive(SetActiveRequest $request): JsonResponse
    {
        $plan = SubscriptionPlan::whereUuid($request->input('planId'));

        if ( ! $plan ) return ApiReturnResponse::notFound('Plan not found');

        return (new SetPlanActiveAction)->execute($plan, $request->input('active'))
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
