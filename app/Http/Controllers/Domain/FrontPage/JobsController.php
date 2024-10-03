<?php

namespace App\Http\Controllers\Domain\FrontPage;

use App\Http\Resources\Domain\FrontPage\JobResource;
use App\Http\Resources\Domain\FrontPage\LatestJobResource;
use App\Http\Resources\Domain\FrontPage\SearchJobResource;
use App\Models\Domain\Employer\EmployerJob;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\Request;

class JobsController
{
    public function searchJobs(Request $request)
    {
        return ApiReturnResponse::success(new SearchJobResource($request));
    }

    public function latestJobs(Request $request)
    {
        return ApiReturnResponse::success(new LatestJobResource($request));
    }

    public function singleJob(string $uuid)
    {
        $job = EmployerJob::whereUuid($uuid);

        return $job ? ApiReturnResponse::success(new JobResource($job)) : ApiReturnResponse::notFound('Job not found');
    }
}
