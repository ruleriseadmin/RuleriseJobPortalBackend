<?php

namespace App\Http\Controllers\Domain\Employer\Job;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Domain\Employer\BaseController;
use App\Actions\Domain\Employer\Job\ChangeHiringStageAction;
use App\Http\Requests\Domain\Employer\Job\ChangeHiringStageRequest;
use App\Http\Requests\Domain\Employer\Job\JobApplicantFilterRequest;
use App\Http\Resources\Domain\Employer\Job\JobApplicantFilterResource;

class JobApplicantController extends BaseController
{
    public function filterApplicantsByJob(string $uuid, JobApplicantFilterRequest $request) : JsonResponse
    {
        $job = $this->employer->jobs()->where('uuid', $uuid)->first();

        if ( ! $job ) return ApiReturnResponse::notFound('Job does not exists');

        $filters = (object) $request->input();

        $filters->job = $job;

        return ApiReturnResponse::success(new JobApplicantFilterResource($filters));
    }

    public function changeHiringStage(ChangeHiringStageRequest $request): JsonResponse
    {
        $job = $this->employer->jobs()->where('uuid', $request->input('jobId'))->first();

        if ( ! $job ) return ApiReturnResponse::notFound('Job does not exists');

        return (new ChangeHiringStageAction)->execute($job, $request->input())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
