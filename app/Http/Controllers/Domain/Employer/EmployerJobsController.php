<?php

namespace App\Http\Controllers\Domain\Employer;

use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Actions\Domain\Employer\Job\CreateJobAction;
use App\Actions\Domain\Employer\Job\DeleteJobAction;
use App\Actions\Domain\Employer\Job\UpdateJobAction;
use App\Http\Requests\Domain\Employer\Job\StoreJobRequest;
use App\Http\Requests\Domain\Employer\Job\UpdateJobRequest;
use App\Http\Resources\Domain\Employer\EmployerJobResource;

class EmployerJobsController extends BaseController
{
    public function index(): JsonResponse
    {
        return ApiReturnResponse::success(EmployerJobResource::collection($this->employer->jobs));
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
    {
        $job = $this->employer->jobs()->where('uuid', $request->input('uuid'))->first();

        if ( ! $job ) return ApiReturnResponse::notFound('Job does not exists');

        $job = (new UpdateJobAction)->execute($job, $request->input());

        //return response
        return $job
            ? ApiReturnResponse::success(new EmployerJobResource($job))
            : ApiReturnResponse::failed();
    }

    public function delete(string $uuid)
    {
        $job = $this->employer->jobs()->where('uuid', $uuid)->first();

        if ( ! $job ) return ApiReturnResponse::notFound('Job does not exists');

        $action = (new DeleteJobAction)->execute($job);

        //return response
        return $action
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function setActiveJob(){}
}
