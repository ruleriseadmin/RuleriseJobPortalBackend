<?php

namespace App\Http\Controllers\Domain\Shared\AccountSetting;

use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Actions\Domain\Shared\AccountSetting\UploadProfilePictureAction;
use App\Http\Requests\Domain\Shared\AccountSetting\UploadProfilePictureRequest;

class UserAccountSettingsController
{
    public function uploadProfilePicture(UploadProfilePictureRequest $request): JsonResponse
    {
        return (new UploadProfilePictureAction)->execute($request->input())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
