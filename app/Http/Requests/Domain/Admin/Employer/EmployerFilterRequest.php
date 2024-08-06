<?php

namespace App\Http\Requests\Domain\Admin\Employer;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class EmployerFilterRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'filterBy' => [Rule::in(['all', 'active', 'inactive', 'blacklisted'])],
        ];
    }
}
