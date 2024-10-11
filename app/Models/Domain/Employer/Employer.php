<?php

namespace App\Models\Domain\Employer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Domain\Shared\HasShadowBanTrait;
use App\Traits\Domain\Shared\HasSubscriptionTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Domain\Employer\Job\CandidateJobPool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Domain\Employer\Job\EmployerJobViewCount;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Domain\Employer\Template\JobNotificationTemplate;

class Employer extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSubscriptionTrait;
    use HasShadowBanTrait;

    protected $guarded = [];

    protected $casts = [
        'benefit_offered' => 'array',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(EmployerUser::class, 'employer_accesses')
            ->withPivot('position_title', 'first_name', 'last_name', 'uuid')
            ->withTimestamps()
            ->using(EmployerAccess::class)->whereNull('soft_deleted', true);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(EmployerJob::class);
    }

    public function jobViewCounts(): HasMany
    {
        return $this->hasMany(EmployerJobViewCount::class);
    }

    public function openJobs(): HasMany
    {
        return $this->jobs()->where('active', true)->where('is_draft', false);
    }

    public function closedJobs(): HasMany
    {
        return $this->jobs()->where('active', false)->where('is_draft', false);
    }

    public function draftJobs(): HasMany
    {
        return $this->jobs()->where('is_draft', true);
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
