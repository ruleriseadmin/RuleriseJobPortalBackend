<?php

namespace App\Http\Requests\Domain\Admin\UserManagement\Role;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Spatie\Permission\Models\Role;

class UpdateRoleRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required'],
            'newRoleName' => ['required'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator){
            if ( $this->filled('slug') ){
                Role::where('guard_name', 'admin')
                    ->where('name', $this->input('slug'))->exists() ? : $validator->errors()->add('slug', 'Role does not exists');
            }

            if ( $this->filled('slug') ){
                $this->input('slug') != 'super_admin' ? : $validator->errors()->add('slug', 'Super Admin cannot be updated');
            }

            if ( $this->filled('newRoleName') ){
                ! Role::where('guard_name', 'admin')
                    ->where('name', str($this->input('newRoleName'))->snake())->exists() ? : $validator->errors()->add('newRoleName', 'Role already exists');
            }
        });
    }
}
