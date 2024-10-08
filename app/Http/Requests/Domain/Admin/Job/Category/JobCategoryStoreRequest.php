<?php

namespace App\Http\Requests\Domain\Admin\Job\Category;
use App\Http\Requests\BaseRequest;

class JobCategoryStoreRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'name' => ['required', 'max:255', 'string', 'unique:job_categories,name'],
            'subcategories' => ['nullable', 'array'],
            'subcategories.*' => ['string', 'max:255'],
        ];
    }
}
