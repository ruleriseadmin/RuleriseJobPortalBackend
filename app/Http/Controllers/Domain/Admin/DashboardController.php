<?php

namespace App\Http\Controllers\Domain\Admin;

use App\Http\Resources\Domain\Admin\AdminDashboardResource;
use App\Supports\ApiReturnResponse;

class DashboardController extends BaseController
{
    public function index()
    {
        return ApiReturnResponse::success(new AdminDashboardResource([]));
    }
}
