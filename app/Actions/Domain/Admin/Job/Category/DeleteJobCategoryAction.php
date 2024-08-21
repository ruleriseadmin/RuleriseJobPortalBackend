<?php

namespace App\Actions\Domain\Admin\Job\Category;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Shared\Job\JobCategories;

class DeleteJobCategoryAction
{
    public function execute(JobCategories $jobCategory) : bool
    {
        try {
            $jobCategory->delete();
        } catch (Exception $ex) {
            Log::error("Error @ DeleteJobCategoryAction::execute : {$ex->getMessage()}");
            return false;
        }

        return true;
    }
}
