<?php

namespace App\Actions\Domain\Admin\Job\Category;

use App\Models\Domain\Shared\Job\JobCategories;

class SetCategoryActiveAction
{
    public function execute(JobCategories $jobCategory)
    {
        $jobCategory->update(['active' => ! $jobCategory->active]);
    }
}
