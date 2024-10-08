<?php

namespace App\Http\Controllers\Domain\Employer\Job;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Actions\Domain\Employer\Job\CreateJobAction;
use App\Actions\Domain\Employer\Job\DeleteJobAction;
use App\Actions\Domain\Employer\Job\UpdateJobAction;
use App\Actions\Domain\Employer\Job\PublishJobAction;
use App\Actions\Domain\Employer\Job\SetOpenCloseAction;
use App\Http\Controllers\Domain\Employer\BaseController;
use App\Http\Requests\Domain\Employer\Job\StoreJobRequest;
use App\Http\Requests\Domain\Employer\Job\UpdateJobRequest;
use App\Http\Resources\Domain\Employer\EmployerJobResource;
use App\Http\Resources\Domain\Employer\EmployerJobFilterResource;

class EmployerJobsController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        $employer = $this->employer;

        $employer['filterBy'] = $request->input('filterBy') ?? '';

        return ApiReturnResponse::success(new EmployerJobFilterResource($employer)); //EmployerJobResource::collection($this->employer->jobs)
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

    public function show(string $uuid)
    {
        $job = $this->employer->jobs()->where('uuid', $uuid)->first();

        return $job
            ? ApiReturnResponse::success(new EmployerJobResource($job))
            : ApiReturnResponse::notFound('Job does not exists');
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

    public function setOpenClose(string $uuid)
    {
        $job = $this->employer->jobs()->where('uuid', $uuid)->first();

        if ( ! $job ) return ApiReturnResponse::notFound('Job does not exists');

        return (new SetOpenCloseAction)->execute($job)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function publishJob(string $uuid)
    {
        $job = $this->employer->jobs()->where('uuid', $uuid)->first();

        if ( ! $job ) return ApiReturnResponse::notFound('Job does not exists');

        return (new PublishJobAction)->execute($job)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
