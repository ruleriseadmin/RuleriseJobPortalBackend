<?php

namespace App\Http\Resources\Domain\Admin;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneralSettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'value' => is_numeric($this->value) ? (bool) $this->value : $this->value,
        ];
    }
}
