<?php

namespace App\Http\Controllers\Domain\Employer;

use App\Http\Resources\Domain\Employer\DashboardResource;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\Request;

class DashboardsController extends BaseController
{
    public function index(Request $request)
    {
        $employer = $this->employer;

        $employer['filterBy'] = $request->only([
            'dateFrom',
            'dateTo',
            'filterOverview',
        ]);

        return ApiReturnResponse::success(new DashboardResource($employer));
    }
}
