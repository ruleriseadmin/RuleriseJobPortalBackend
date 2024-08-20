<?php

namespace App\Http\Controllers\Domain\Candidate\Job;
use App\Actions\Domain\Candidate\Job\DeleteCVAction;
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
        return ApiReturnResponse::success(CVResource::collection($this->user->cvs));
    }

    public function uploadCv(UploadCVRequest $request): JsonResponse
    {
        $cvDocument = (new UploadCVAction)->execute($request->input());

        return $cvDocument ? ApiReturnResponse::success(new CVResource($cvDocument)) : ApiReturnResponse::failed();
    }

    public function delete(string $uuid)
    {
        $cv = $this->user->cvs()->where('uuid', $uuid)->first();

        if ( ! $cv ) return ApiReturnResponse::notFound('Cv not found');

        return (new DeleteCVAction)->execute($cv)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
