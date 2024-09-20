<?php

namespace App\Http\Controllers\Domain\Shared\AccountSetting;

use App\Http\Controllers\Domain\Candidate\BaseController;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Actions\Domain\Shared\AccountSetting\UploadProfilePictureAction;
use App\Http\Requests\Domain\Shared\AccountSetting\UploadProfilePictureRequest;

class UserAccountSettingsController extends BaseController
{
    public function uploadProfilePicture(UploadProfilePictureRequest $request): JsonResponse
    {
        $uploadLogo = (new UploadProfilePictureAction)->execute($request->input());
        return $uploadLogo
            ? ApiReturnResponse::success(['profilePictureUrl' => asset("/storage/{$this->user->refresh()->profile_picture_url}")])
            : ApiReturnResponse::failed();
    }
}
