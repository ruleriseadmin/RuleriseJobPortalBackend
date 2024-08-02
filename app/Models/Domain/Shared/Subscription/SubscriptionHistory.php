<?php

namespace App\Models\Domain\Shared\Subscription;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'subscribable_id',
        'subscribable_type',
        'subscription_plan_id',
        'start_at',
        'end_at',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function subscribable(): MorphTo
    {
        return $this->morphTo();
    }
}
