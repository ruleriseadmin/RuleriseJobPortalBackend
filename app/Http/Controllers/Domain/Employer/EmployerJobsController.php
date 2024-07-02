<?php

namespace App\Http\Controllers\Domain\Employer;

use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Actions\Domain\Employer\Job\CreateJobAction;
use App\Http\Requests\Domain\Employer\Job\StoreJobRequest;
use App\Http\Requests\Domain\Employer\Job\UpdateJobRequest;
use App\Http\Resources\Domain\Employer\EmployerJobResource;

class EmployerJobsController extends BaseController
{
    public function index(): JsonResponse
    {
        return ApiReturnResponse::success();
    }

    public function store(StoreJobRequest $request)
    {
        $job = (new CreateJobAction)->execute($this->employer, $request->input());

        //return response
        return $job
            ? ApiReturnResponse::success(new EmployerJobResource($job))
            : ApiReturnResponse::failed();
    }

    public function update(UpdateJobRequest $request)
    {}

    public function delete(){}

    public function setActiveJob(){}
}
