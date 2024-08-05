<?php

namespace App\Models\Domain\Employer\Template;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobNotificationTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'rejected_template',
        'shortlisted_template',
        'offer_sent_template',
    ];

    const  TEMPLATES = [
        'rejected_template' => 'rejected_template',
        'shortlisted_template' => 'shortlisted_template',
        'offer_sent_template' => 'offer_sent_template',
    ];

    protected $casts = [
        'rejected_template' => 'array',
        'shortlisted_template' => 'array',
        'offer_sent_template' => 'array',
    ];
}
