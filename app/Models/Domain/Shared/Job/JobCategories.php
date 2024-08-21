<?php

namespace App\Models\Domain\Shared\Job;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCategories extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['uuid', 'name', 'subcategories'];

    protected $casts = [
        'subcategories' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) str()->uuid();
        });
    }

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid)->first();
    }
}
