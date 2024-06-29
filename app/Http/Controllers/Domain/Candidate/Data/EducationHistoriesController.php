<?php

namespace App\Http\Controllers\Domain\Candidate\Data;

use App\Actions\Domain\Candidate\EducationHistory\CreateEducationHistoryAction;
use App\Actions\Domain\Candidate\EducationHistory\DeleteEducationHistoryAction;
use App\Actions\Domain\Candidate\EducationHistory\UpdateEducationHistoryAction;
use App\Http\Controllers\Domain\Candidate\BaseController;
use App\Http\Requests\Domain\Candidate\EducationHistory\StoreCandidateEducationHistoryRequest;
use App\Http\Requests\Domain\Candidate\EducationHistory\UpdateCandidateEducationHistoryRequest;
use App\Http\Resources\Domain\Candidate\Data\EducationHistoryResource;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\JsonResponse;

class EducationHistoriesController extends BaseController
{
    public function store(StoreCandidateEducationHistoryRequest $request) : JsonResponse
    {
        $workExperience = (new CreateEducationHistoryAction)->execute($this->user, $request->input());

        //return response
        return $workExperience ? ApiReturnResponse::success(new EducationHistoryResource($workExperience)) : ApiReturnResponse::failed();
    }

    public function update(UpdateCandidateEducationHistoryRequest $request) : JsonResponse
    {
        $workExperience = $this->user->educationHistories()->where('uuid', $request->input('uuid'))->first();

        if ( ! $workExperience ) return ApiReturnResponse::notFound('Education history does not exists');

        //call action
        $workExperience = (new UpdateEducationHistoryAction)->execute($workExperience, $request->input());

        //return response
        return $workExperience ? ApiReturnResponse::success(new EducationHistoryResource($workExperience)) : ApiReturnResponse::failed();
    }

    public function delete(string $uuid) : JsonResponse
    {
        $workExperience = $this->user->educationHistories()->where('uuid', $uuid)->first();

        if ( ! $workExperience ) return ApiReturnResponse::notFound('Education history does not exists');

        return (new DeleteEducationHistoryAction)->execute($workExperience)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
