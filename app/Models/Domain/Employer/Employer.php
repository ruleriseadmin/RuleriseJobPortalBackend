<?php

namespace App\Models\Domain\Employer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'benefit_offered' => 'string',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(EmployerUser::class, 'employer_accesses')
            ->withPivot('position_title')
            ->withTimestamps()
            ->using(EmployerAccess::class);
    }
}
