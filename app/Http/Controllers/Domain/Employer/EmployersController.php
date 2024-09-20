<?php

namespace App\Http\Controllers\Domain\Employer;

use App\Supports\ApiReturnResponse;
use App\Actions\Domain\Employer\UploadLogoAction;
use App\Actions\Domain\Employer\DeleteEmployerAction;
use App\Actions\Domain\Employer\UpdateEmployerAction;
use App\Http\Resources\Domain\Employer\ProfileResource;
use App\Http\Requests\Domain\Employer\UploadLogoRequest;
use App\Http\Requests\Domain\Employer\UpdateProfileRequest;

class EmployersController extends BaseController
{
    public function getProfile()
    {
        return ApiReturnResponse::success(new ProfileResource($this->employer));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $updateProfile = (new UpdateEmployerAction)->execute($this->employer, $this->user, $request->input());

        return $updateProfile
            ? ApiReturnResponse::success(new ProfileResource($this->employer))
            : ApiReturnResponse::failed();
    }

    public function deleteAccount()
    {
        return (new DeleteEmployerAction)->execute($this->employer, $this->user)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function uploadLogo(UploadLogoRequest $request)
    {
        $uploadLogo = (new UploadLogoAction)->execute($this->employer, $request->input());

        return $uploadLogo
            ? ApiReturnResponse::success(['logoUrl' => asset("/storage/{$this->employer->refresh()->logo_url}")])
            : ApiReturnResponse::failed();
    }
}
