<?php

namespace App\Http\Controllers\Domain\Candidate\Job;
use App\Http\Resources\Domain\Candidate\CVResource;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Actions\Domain\Candidate\Job\UploadCVAction;
use App\Http\Controllers\Domain\Candidate\BaseController;
use App\Http\Requests\Domain\Candidate\Job\UploadCVRequest;

class CVsController extends BaseController
{
    public function cvDetail(): JsonResponse
    {
        return ApiReturnResponse::success(new CVResource($this->user->cv));
    }

    public function uploadCv(UploadCVRequest $request): JsonResponse
    {
        return (new UploadCVAction)->execute($request->input())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
