<?php

namespace App\Http\Controllers\Domain\Candidate;

use App\Actions\Domain\Candidate\DeleteAccountAction;
use App\Actions\Domain\Candidate\UpdateProfileAction;
use App\Http\Requests\Domain\Candidate\Profile\UpdateAccountRequest;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Domain\Candidate\ProfileResource;

class AccountSettingsController extends BaseController
{
    public function index()
    {
        $user = $this->user;

        $user['only_account'] = true;

        return ApiReturnResponse::success(new ProfileResource($user));
    }

    public function updateAccountSetting(UpdateAccountRequest $request): JsonResponse
    {
        //update account setting
        $user = (new UpdateProfileAction)->execute($this->user, $request->input());

        ! $user ?: $user['only_account'] = true;

        return $user
            ? ApiReturnResponse::success(new ProfileResource($user->withoutRelations()))
            : ApiReturnResponse::failed();
    }

    public function deleteAccount(): JsonResponse
    {
        return (new DeleteAccountAction)->execute($this->user)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
