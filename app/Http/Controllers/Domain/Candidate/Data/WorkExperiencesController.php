<?php

namespace App\Http\Controllers\Domain\Candidate\Data;
use App\Actions\Domain\Candidate\WorkExperience\CreateWorkExperienceAction;
use App\Actions\Domain\Candidate\WorkExperience\DeleteWorkExperienceAction;
use App\Actions\Domain\Candidate\WorkExperience\UpdateWorkExperienceAction;
use App\Http\Controllers\Domain\Candidate\BaseController;
use App\Http\Requests\Domain\Candidate\WorkExperience\StoreCandidateWorkExperienceRequest;
use App\Http\Requests\Domain\Candidate\WorkExperience\UpdateCandidateWorkExperienceRequest;
use App\Http\Resources\Domain\Candidate\Data\WorkExperienceResource;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\JsonResponse;

class WorkExperiencesController extends BaseController
{
    public function store(StoreCandidateWorkExperienceRequest $request) : JsonResponse
    {
        $workExperience = (new CreateWorkExperienceAction)->execute($this->user, $request->input());

        //return response
        return $workExperience ? ApiReturnResponse::success(new WorkExperienceResource($workExperience)) : ApiReturnResponse::failed();
    }

    public function update(UpdateCandidateWorkExperienceRequest $request) : JsonResponse
    {
        $workExperience = $this->user->workExperiences()->where('uuid', $request->input('uuid'))->first();

        if ( ! $workExperience ) return ApiReturnResponse::notFound('Work experience does not exists');

        //call action
        $workExperience = (new UpdateWorkExperienceAction)->execute($workExperience, $request->input());

        //return response
        return $workExperience ? ApiReturnResponse::success(new WorkExperienceResource($workExperience)) : ApiReturnResponse::failed();
    }

    public function delete(string $uuid) : JsonResponse
    {
        $workExperience = $this->user->workExperiences()->where('uuid', $uuid)->first();

        if ( ! $workExperience ) return ApiReturnResponse::notFound('Work experience does not exists');

        return (new DeleteWorkExperienceAction)->execute($workExperience)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
