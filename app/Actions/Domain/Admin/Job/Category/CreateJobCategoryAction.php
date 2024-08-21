<?php

namespace App\Actions\Domain\Admin\Job\Category;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Shared\Job\JobCategories;

class CreateJobCategoryAction
{
    public function execute(array $data) : ?JobCategories
    {
        try {
            $jobCategory = JobCategories::create([
                'name' => $data['name'],
                'subcategories' => $data['subcategories'] ?? [],
            ]);
        } catch (Exception $ex) {
            Log::error("Error @ CreateJobCategoryAction::execute : {$ex->getMessage()}");
            return null;
        }

        return $jobCategory;
    }
}
