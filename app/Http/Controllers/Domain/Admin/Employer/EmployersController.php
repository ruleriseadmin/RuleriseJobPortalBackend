<?php

namespace App\Http\Controllers\Domain\Admin\Employer;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Domain\Admin\BaseController;
use App\Http\Requests\Domain\Admin\Employer\EmployerFilterRequest;
use App\Http\Resources\Domain\Admin\Employer\EmployerFilterResource;

class EmployersController extends BaseController
{
    public function index(EmployerFilterRequest $request)
    {
        return ApiReturnResponse::success(new EmployerFilterResource($request->input()));
    }

    public function show(){}

    public function delete(){}
}
