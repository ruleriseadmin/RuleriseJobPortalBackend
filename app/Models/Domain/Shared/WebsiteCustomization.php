<?php

namespace App\Models\Domain\Shared;

use App\Traits\Domain\Shared\WebsiteCrm\AboutUsTrait;
use App\Traits\Domain\Shared\WebsiteCrm\AdBannerTrait;
use App\Traits\Domain\Shared\WebsiteCrm\ContactTrait;
use App\Traits\Domain\Shared\WebsiteCrm\HeroSectionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteCustomization extends Model
{
    use HasFactory;
    use HeroSectionTrait, AboutUsTrait, ContactTrait, AdBannerTrait;

    protected $fillable = [
        'name',
        'type',
        'value',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    const TYPES = [
        'hero_section' => 'hero_section',
        'about_us' => 'about_us',
        'contact' => 'contact',
        'ad_banner' => 'ad_banner',
    ];

    public static function whereAllByType(string $type)
    {
        return self::query()->where('type', $type)->get();
    }
}
