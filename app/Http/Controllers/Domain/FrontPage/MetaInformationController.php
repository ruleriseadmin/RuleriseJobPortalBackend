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

    public function getSingleCategory(string $uuid)
    {
        $category = JobCategories::where('uuid', $uuid)->first();

        $category && $category['withJobs'] = true;

        return $category
            ? ApiReturnResponse::success(new CategoryResource($category))
            : ApiReturnResponse::notFound('Category does not exists');
    }
}
