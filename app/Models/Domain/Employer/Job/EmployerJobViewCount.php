<?php

namespace App\Models\Domain\Employer\Job;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerJobViewCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'employer_job_id',
        'view_count',
        'apply_count',
    ];
}
