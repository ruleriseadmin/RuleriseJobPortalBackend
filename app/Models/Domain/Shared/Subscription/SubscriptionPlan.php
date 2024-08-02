<?php

namespace App\Models\Domain\Shared\Subscription;

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
        'interval', // day, month, year
        'interval_count',
        'product_id',
        'trial_period_days',
        'package_duration', // verify if this in use
        'quota', // number_of_candidate
        'duration', //how long in integer
        'group', // helps to segment plan for different modules or users
    ];

    public static function whereUuid(string $uuid)
    {
        return self::where('uuid', $uuid)->first();
    }
}
