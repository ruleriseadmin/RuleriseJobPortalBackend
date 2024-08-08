<?php

namespace App\Http\Requests\Domain\Admin\Moderation;
use App\Http\Requests\BaseRequest;
use App\Models\Domain\Shared\Moderation\ShadowBan;
use Illuminate\Validation\Rule;

class SetShadowBanRequest extends BaseRequest
{
    public function rules():array
    {
        return [
            'type' => ['required', Rule::in(ShadowBan::TYPE)],
        ];
    }
}
