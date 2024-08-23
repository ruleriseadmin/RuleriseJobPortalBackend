<?php

namespace App\Actions\Domain\Admin\Job\Category;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Shared\Job\JobCategories;
use App\Supports\HelperSupport;

class CreateJobCategoryAction
{
    public function execute(array $data) : ?JobCategories
    {
        try {
            $jobCategory = JobCategories::create(HelperSupport::camel_to_snake($data));
        } catch (Exception $ex) {
            Log::error("Error @ CreateJobCategoryAction::execute : {$ex->getMessage()}");
            return null;
        }

        return $jobCategory;
    }
}
