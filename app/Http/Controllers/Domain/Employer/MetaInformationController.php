<?php

namespace App\Http\Controllers\Domain\Employer;

use App\Supports\ApiReturnResponse;

class MetaInformationController extends BaseController
{
    public function getJobCategory()
    {
        return ApiReturnResponse::success(['Agriculture']);
    }
}
