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
            'roleName' => ['required'],
            'newRoleName' => ['required'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator){
            if ( $this->filled('roleName') ){
                Role::where('guard_name', 'admin')
                    ->where('name', str($this->input('roleName'))->snake())->exists() ? : $validator->errors()->add('roleName', 'Role does not exists');
            }

            if ( $this->filled('roleName') ){
                str($this->input('roleName'))->snake() != 'super_admin' ? : $validator->errors()->add('roleName', 'Super Admin cannot be updated');
            }

            if ( $this->filled('newRoleName') ){
                ! Role::where('guard_name', 'admin')
                    ->where('name', str($this->input('newRoleName'))->snake())->exists() ? : $validator->errors()->add('roleName', 'Role already exists');
            }
        });
    }
}
