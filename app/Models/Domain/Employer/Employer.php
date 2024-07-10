<?php

namespace App\Models\Domain\Employer;

use App\Models\Domain\Employer\Job\CandidateJobPool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'benefit_offered' => 'array',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(EmployerUser::class, 'employer_accesses')
            ->withPivot('position_title')
            ->withTimestamps()
            ->using(EmployerAccess::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(EmployerJob::class);
    }

    public function candidatePools(): HasMany
    {
        return $this->hasMany(CandidateJobPool::class);
    }
}
