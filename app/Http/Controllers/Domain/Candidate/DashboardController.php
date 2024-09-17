<?php

namespace App\Http\Controllers\Domain\Candidate;

use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Http\Resources\Domain\Candidate\DashboardMetricsResource;

class DashboardController extends BaseController
{
    public function metrics(): JsonResponse
    {
        return ApiReturnResponse::success(new DashboardMetricsResource($this->user));
    }

}
