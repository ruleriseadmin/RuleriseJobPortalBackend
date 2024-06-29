<?php

namespace App\Http\Controllers\Domain\Candidate\Data;

use App\Actions\Domain\Candidate\CandidateLanguage\CreateCandidateLanguageAction;
use App\Actions\Domain\Candidate\CandidateLanguage\DeleteCandidateLanguageAction;
use App\Actions\Domain\Candidate\CandidateLanguage\UpdateCandidateLanguageAction;
use App\Http\Controllers\Domain\Candidate\BaseController;
use App\Http\Requests\Domain\Candidate\CandidateLanguage\StoreCandidateLanguageRequest;
use App\Http\Requests\Domain\Candidate\CandidateLanguage\UpdateCandidateLanguageRequest;
use App\Http\Resources\Domain\Candidate\Data\LanguageResource;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\JsonResponse;

class CandidateLanguagesController extends BaseController
{
    public function store(StoreCandidateLanguageRequest $request) : JsonResponse
    {
        $language = (new CreateCandidateLanguageAction)->execute($this->user, $request->input());

        //return response
        return $language ? ApiReturnResponse::success(new LanguageResource($language)) : ApiReturnResponse::failed();
    }

    public function update(UpdateCandidateLanguageRequest $request) : JsonResponse
    {
        $language = $this->user->languages()->where('uuid', $request->input('uuid'))->first();

        if ( ! $language ) return ApiReturnResponse::notFound('Language does not exists');

        //call action
        $language = (new UpdateCandidateLanguageAction)->execute($language, $request->input());

        //return response
        return $language ? ApiReturnResponse::success(new LanguageResource($language)) : ApiReturnResponse::failed();
    }

    public function delete(string $uuid) : JsonResponse
    {
        $language = $this->user->languages()->where('uuid', $uuid)->first();

        if ( ! $language ) return ApiReturnResponse::notFound('Language does not exists');

        return (new DeleteCandidateLanguageAction)->execute($language)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
