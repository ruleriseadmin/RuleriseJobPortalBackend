<?php

namespace App\Models\Domain\Candidate\Job;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateSavedJob extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'job_ids',
    ];

    protected $casts = [
        'job_ids' => 'array',
    ];
}
