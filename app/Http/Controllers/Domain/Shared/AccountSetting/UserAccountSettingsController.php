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
        $uploadLogo = (new UploadProfilePictureAction)->execute($request->input());

        $user = auth()->user();
        
        return $uploadLogo
            ? ApiReturnResponse::success(['profilePictureUrl' => asset("/storage/{$user->refresh()->profile_picture_url}")])
            : ApiReturnResponse::failed();
    }
}
