<?php

namespace App\Http\Controllers\Domain\FrontPage;

use App\Http\Resources\Domain\FrontPage\FrontPageResource;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\JsonResponse;

class FrontPagesController
{
    public function index(): JsonResponse
    {
        return ApiReturnResponse::success(new FrontPageResource([]));
    }
}
