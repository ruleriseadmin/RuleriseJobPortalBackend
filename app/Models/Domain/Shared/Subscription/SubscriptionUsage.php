<?php

namespace App\Models\Domain\Shared\Subscription;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionUsage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'subscription_id',
        'quota',
        'quota_used',
        'quota_remaining',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}
