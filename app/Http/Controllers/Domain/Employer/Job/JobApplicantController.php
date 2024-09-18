<?php

namespace App\Http\Controllers\Domain\Employer\Job;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Domain\Employer\BaseController;
use App\Actions\Domain\Employer\Job\ChangeHiringStageAction;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use App\Http\Resources\Domain\Employer\Job\JobApplicantResource;
use App\Http\Requests\Domain\Employer\Job\ChangeHiringStageRequest;
use App\Http\Resources\Domain\Employer\Job\CandidateFilterResource;
use App\Http\Requests\Domain\Employer\Job\JobApplicantFilterRequest;
use App\Http\Resources\Domain\Employer\Job\JobApplicantFilterByJobResource;

class JobApplicantController extends BaseController
{
    public function filterApplicantsByJob(string $uuid, JobApplicantFilterRequest $request) : JsonResponse
    {
        $job = $this->employer->jobs()->where('uuid', $uuid)->first();

        if ( ! $job ) return ApiReturnResponse::notFound('Job does not exists');

        $filters = (object) $request->input();

        $filters->job = $job;

        return ApiReturnResponse::success(new JobApplicantFilterByJobResource($filters));
    }

    public function changeHiringStage(ChangeHiringStageRequest $request): JsonResponse
    {
        logger('oya na');
        $job = $this->employer->jobs()->where('uuid', $request->input('jobId'))->first();

        if ( ! $job ) return ApiReturnResponse::notFound('Job does not exists');

        return (new ChangeHiringStageAction)->execute($job, $request->input())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function viewApplication(string $uuid)
    {
        $application = CandidateJobApplication::whereUuid($uuid);

        return $application
            ? ApiReturnResponse::success(new JobApplicantResource($application))
            : ApiReturnResponse::notFound('Job does not exists');
    }
}
