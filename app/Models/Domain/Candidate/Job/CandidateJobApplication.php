<?php

namespace App\Models\Domain\Candidate\Job;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;

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
    ];

    const APPLIED_VIA = [
        'profile_cv' => 'profile_cv',
        'custom_cv' => 'custom_cv',
    ];
}
