<?php

namespace App\Models\Domain\Shared;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'plan_id',
        'name',
        'description',
        'active',
        'amount',
        'currency',
        'interval',
        'interval_count',
        'product_id',
        'trial_period_days',
        'package_duration',
        'number_of_candidate',
        'duration',
    ];

    public static function whereUuid(string $uuid)
    {
        return self::where('uuid', $uuid)->first();
    }
}
