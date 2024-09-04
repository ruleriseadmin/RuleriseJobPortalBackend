<?php

namespace App\Models\Domain\Shared\Job;

use App\Models\Domain\Employer\EmployerJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCategories extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['uuid', 'name', 'subcategories', 'svg_icon', 'active'];

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

    public function jobs(): HasMany
    {
        return $this->hasMany(EmployerJob::class, 'category_id', 'id');
    }

    public function openJobs(): HasMany
    {
        return $this->jobs()->where('active', true)->where('is_draft', false);
    }

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid)->first();
    }
}
