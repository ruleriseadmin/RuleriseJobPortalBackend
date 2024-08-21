<?php

namespace App\Http\Controllers\Domain\FrontPage;

use App\Supports\ApiReturnResponse;
use App\Models\Domain\Shared\Job\JobCategories;
use App\Http\Resources\Domain\Admin\Job\CategoryResource;

class MetaInformationController
{
    public function getJobCategory()
    {
        return ApiReturnResponse::success(CategoryResource::collection(JobCategories::all()));
    }
}
