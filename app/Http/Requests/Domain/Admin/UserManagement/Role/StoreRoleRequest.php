<?php

namespace App\Http\Requests\Domain\Admin\UserManagement\Role;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Spatie\Permission\Models\Role;

class StoreRoleRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'roleName' => ['required'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator){

            if ( $this->filled('roleName') ){
                ! Role::where('guard_name', 'admin')
                    ->where('name', str($this->input('roleName'))->snake())->exists() ? : $validator->errors()->add('roleName', 'Role already exists');
            }
        });
    }
}
