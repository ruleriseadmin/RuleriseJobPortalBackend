<?php

namespace App\Models\Domain\Employer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Domain\Shared\HasSubscriptionTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Domain\Employer\Job\CandidateJobPool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Domain\Employer\Template\JobNotificationTemplate;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employer extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSubscriptionTrait;

    protected $guarded = [];

    protected $casts = [
        'benefit_offered' => 'array',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(EmployerUser::class, 'employer_accesses')
            ->withPivot('position_title', 'first_name', 'last_name')
            ->withTimestamps()
            ->using(EmployerAccess::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(EmployerJob::class);
    }

    public function openJobs(): HasMany
    {
        return $this->jobs()->where('active', true);
    }

    public function closedJobs(): HasMany
    {
        return $this->jobs()->where('active', false);
    }

    public function candidatePools(): HasMany
    {
        return $this->hasMany(CandidateJobPool::class);
    }

    public function jobNotificationTemplate(): HasOne
    {
        return $this->hasOne(JobNotificationTemplate::class);
    }

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid)->first();
    }
}
