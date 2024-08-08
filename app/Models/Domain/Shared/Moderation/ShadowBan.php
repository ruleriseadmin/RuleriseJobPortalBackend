<?php

namespace App\Models\Domain\Shared\Moderation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShadowBan extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'expires_at',
        'modulable_id',
        'modulable_type',
        'subscription_plan_id',
    ];

    const TYPE = [
        'ban_post_job' => 'ban_post_job',
        'ban_apply_job' => 'ban_apply_job',
    ];

    public function modulable(): MorphTo
    {
        return $this->morphTo();
    }
}
