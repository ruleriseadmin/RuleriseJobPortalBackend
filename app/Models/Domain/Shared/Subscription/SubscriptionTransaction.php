<?php

namespace App\Models\Domain\Shared\Subscription;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'reference',
        'amount',
        'currency',
        'status',
        'subscribable_id',
        'subscribable_type',
        'subscription_plan_id',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    const  PENDING_STATUS = 'pending';

    const  SUCCESS_STATUS = 'success';

    const  FAILED_STATUS = 'failed';

    public function subscribable(): MorphTo
    {
        return $this->morphTo();
    }

    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public static function whereReference(string $reference)
    {
        return self::where('reference', $reference)->first();
    }
}
