<?php

namespace App\Http\Controllers\Domain\Admin\Job;

use App\Supports\ApiReturnResponse;
use App\Models\Domain\Shared\Job\JobCategories;
use App\Http\Resources\Domain\Admin\Job\CategoryResource;
use App\Actions\Domain\Admin\Job\Category\CreateJobCategoryAction;
use App\Actions\Domain\Admin\Job\Category\DeleteJobCategoryAction;
use App\Actions\Domain\Admin\Job\Category\UpdateJobCategoryAction;
use App\Http\Requests\Domain\Admin\Job\Category\JobCategoryStoreRequest;
use App\Http\Requests\Domain\Admin\Job\Category\JobCategoryUpdateRequest;

class JobCategoriesController
{
    public function index()
    {
        $categories = JobCategories::all();

        return ApiReturnResponse::success(CategoryResource::collection($categories));
    }

    public function store(JobCategoryStoreRequest $request)
    {
        $category = (new CreateJobCategoryAction)->execute($request->input());

        return $category ? ApiReturnResponse::success() : ApiReturnResponse::failed();
    }

    public function show(string $uuid)
    {
        $category = JobCategories::whereUuid($uuid);

        if ( ! $category ) return ApiReturnResponse::notFound('Category does not exists');

        return ApiReturnResponse::success(new CategoryResource($category));
    }

    public function update(JobCategoryUpdateRequest $request)
    {
        $category = JobCategories::whereUuid($request->input('categoryId'));

        return (new UpdateJobCategoryAction)->execute($category, $request->input())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function delete(string $uuid)
    {
        $category = JobCategories::whereUuid($uuid);

        if ( ! $category ) return ApiReturnResponse::notFound('Category does not exists');

        return (new DeleteJobCategoryAction)->execute($category)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
