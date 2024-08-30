<?php

namespace App\Http\Requests;

use App\Supports\ApiReturnResponse;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            ApiReturnResponse::validationError($errors)->send()
        );
    }

    public function withValidator(Validator $validator)
    {
        //$validator->errors()->add('', '');

        $validator->after(function (){
            //insert rule inside
        });
    }
}
