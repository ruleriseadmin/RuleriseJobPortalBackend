<?php

namespace App\Http\Requests\Domain\Admin\Job\Category;
use App\Http\Requests\BaseRequest;

class JobCategoryUpdateRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'categoryId' => ['required', 'exists:job_categories,uuid'],
            'name' => ['required', 'max:255', 'string'],
            'subcategories' => ['nullable', 'array'],
            'subcategories.*' => ['string', 'max:255'],
        ];
    }
}
