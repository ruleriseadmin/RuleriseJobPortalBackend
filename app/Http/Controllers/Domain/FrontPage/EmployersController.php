<?php

namespace App\Http\Controllers\Domain\FrontPage;

use App\Http\Resources\Domain\FrontPage\Employer\EmployerFilterResource;
use Illuminate\Http\Request;
use App\Supports\ApiReturnResponse;
use App\Models\Domain\Employer\Employer;
use App\Http\Resources\Domain\FrontPage\Employer\EmployerResource;

class EmployersController
{
    public function index()
    {
        return ApiReturnResponse::success(new EmployerFilterResource([]));
    }

    public function show(string $uuid)
    {
        $employer = Employer::whereUuid($uuid);

        return $employer
            ? ApiReturnResponse::success(new EmployerResource($employer))
            : ApiReturnResponse::notFound('Employer not found');
    }
}
