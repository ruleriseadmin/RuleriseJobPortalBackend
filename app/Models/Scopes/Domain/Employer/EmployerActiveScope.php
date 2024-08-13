<?php

namespace App\Models\Scopes\Domain\Employer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class EmployerActiveScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereHas('employer', function (Builder $query) {
            $query->whereNull('deleted_at');
        });
    }
}
