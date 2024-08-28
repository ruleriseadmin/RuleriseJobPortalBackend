<?php

namespace App\Models\Domain\Candidate\Job;

use Spatie\ModelStatus\HasStatuses;
use App\Models\Domain\Candidate\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Domain\Candidate\CVDocument;
use App\Models\Domain\Employer\EmployerJob;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Domain\Candidate\CandidateJobHiringStageTrait;

class CandidateJobApplication extends Model
{
    use HasFactory;
    use SoftDeletes;
    //use HasStatuses;
    use CandidateJobHiringStageTrait;

    protected $fillable = [
        'uuid',
        'user_id',
        'job_id',
        'applied_via',
        'cv_url',
        'hiring_stage',
    ];

    protected $casts = [
        'hiring_stage' => 'array',
    ];

    const STATUSES = [
        'applied' => 'applied',
        'viewed' => 'viewed',
        'rejected' => 'rejected',
        'shortlisted' => 'shortlisted',
        'offer_sent' => 'offer_sent',
        'unsorted' => 'unsorted',
    ];

    const APPLIED_VIA = [
        'profile_cv' => 'profile_cv',
        'custom_cv' => 'custom_cv',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(EmployerJob::class, 'job_id', 'id');
    }

    public function cv(): BelongsTo
    {
        return $this->belongsTo(CVDocument::class, 'cv_url', 'id');
    }

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid)->first();
    }
}
