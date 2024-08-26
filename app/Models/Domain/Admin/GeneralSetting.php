<?php

namespace App\Models\Domain\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralSetting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'value',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public static function whereName(string $name)
    {
        return self::query()->where('name', $name)->first();
    }
}
