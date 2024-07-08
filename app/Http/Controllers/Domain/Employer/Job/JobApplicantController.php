<?php

namespace App\Http\Controllers\Domain\Employer\Job;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Domain\Employer\BaseController;
use App\Http\Requests\Domain\Employer\Job\JobApplicantFilterRequest;
use App\Http\Resources\Domain\Employer\Job\JobApplicantFilterResource;

class JobApplicantController extends BaseController
{
    public function index(string $uuid, JobApplicantFilterRequest $request) : JsonResponse
    {
        $job = $this->employer->jobs()->where('uuid', $uuid)->first();

        if ( ! $job ) return ApiReturnResponse::notFound('Job does not exists');

        $filters = (object) $request->input();

        $filters->job = $job;

        return ApiReturnResponse::success(new JobApplicantFilterResource($filters));
    }
}
