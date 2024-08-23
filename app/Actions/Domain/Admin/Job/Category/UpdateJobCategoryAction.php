<?php

namespace App\Actions\Domain\Admin\Job\Category;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Shared\Job\JobCategories;
use App\Supports\HelperSupport;

class UpdateJobCategoryAction
{
    public function execute(JobCategories $jobCategory, array $data) : ?JobCategories
    {
        $data['subcategories'] = $data['subcategories'] ?? $jobCategory->subcategories;

        try {
            $jobCategory->update(HelperSupport::camel_to_snake($data));
        } catch (Exception $ex) {
            Log::error("Error @ UpdateJobCategoryAction::execute : {$ex->getMessage()}");
            return null;
        }

        return $jobCategory;
    }
}
