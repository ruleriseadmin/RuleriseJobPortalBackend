<?php

namespace App\Actions\Domain\Admin\Job\Category;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Shared\Job\JobCategories;

class UpdateJobCategoryAction
{
    public function execute(JobCategories $jobCategory, array $data) : ?JobCategories
    {
        try {
            $jobCategory->update([
                'name' => $data['name'],
                'subcategories' => $data['subcategories'] ?? $jobCategory->subcategories,
            ]);
        } catch (Exception $ex) {
            Log::error("Error @ UpdateJobCategoryAction::execute : {$ex->getMessage()}");
            return null;
        }

        return $jobCategory;
    }
}
