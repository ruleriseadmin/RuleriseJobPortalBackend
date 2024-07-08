<?php

namespace App\Models\Domain\Candidate\Job;

use Spatie\ModelStatus\HasStatuses;
use App\Models\Domain\Candidate\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateJobApplication extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasStatuses;

    protected $fillable = [
        'uuid',
        'user_id',
        'job_id',
        'applied_via',
        'cv_url',
    ];

    const STATUSES = [
        'applied' => 'applied',
        'viewed' => 'viewed',
        'rejected' => 'rejected',
    ];

    const APPLIED_VIA = [
        'profile_cv' => 'profile_cv',
        'custom_cv' => 'custom_cv',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
