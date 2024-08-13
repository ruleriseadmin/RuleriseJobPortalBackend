<?php

namespace App\Http\Controllers\Domain\Candidate\Job;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Models\Domain\Employer\EmployerJob;
use App\Actions\Domain\Candidate\Job\ApplyJobAction;
use App\Http\Resources\Domain\Candidate\JobResource;
use App\Http\Controllers\Domain\Candidate\BaseController;
use App\Actions\Domain\Candidate\Job\SaveAndUnsafeJobAction;
use App\Http\Requests\Domain\Candidate\Job\JobFilterRequest;
use App\Http\Resources\Domain\Candidate\Job\JobFilterResource;
use App\Actions\Domain\Candidate\Job\IncrementJobViewCountAction;
use App\Http\Requests\Domain\Candidate\Job\JobApplicationRequest;

class JobsController extends BaseController
{
    public function index(JobFilterRequest $request) : JsonResponse
    {
        $filters = (object) $request->input();

        return ApiReturnResponse::success(new JobFilterResource($filters));
    }

    public function show(string $uuid) : JsonResponse
    {
        $job = EmployerJob::whereUuid($uuid);

        if ( ! $job ) return ApiReturnResponse::notFound('Job not found');

        //increment job view
        (new IncrementJobViewCountAction)->execute($job);

        return ApiReturnResponse::success(new JobResource($job));
    }

    public function applyJob(JobApplicationRequest $request) : JsonResponse
    {
        $job = EmployerJob::whereUuid($request->input('jobId'));

        $appliedJob = (new ApplyJobAction)
            ->execute($this->user, $job, $request->input('applyVia'), $request->input('cvId'));

        return $appliedJob
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function saveJob(string $uuid) : JsonResponse
    {
        $job = EmployerJob::whereUuid($uuid);

        if ( ! $job ) return ApiReturnResponse::notFound('Job not found');

        return (new SaveAndUnsafeJobAction)->execute($this->user, $job)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function viewJob(){}
}
