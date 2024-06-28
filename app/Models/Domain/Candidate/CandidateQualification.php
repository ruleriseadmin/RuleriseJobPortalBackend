<?php

namespace App\Models\Domain\Candidate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateQualification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'highest_qualification',
        'year_of_experience',
        'prefer_job_industry',
        'available_to_work',
        'skills',
        'career_level',
        'functional_areas',
    ];

    protected $casts = [
        'skills' => 'array',
        'career_level' => 'array',
    ];
}
