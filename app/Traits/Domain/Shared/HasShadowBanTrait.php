<?php

namespace App\Traits\Domain\Shared;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Shared\Moderation\ShadowBan;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasShadowBanTrait
{
    public function shadowBans(): MorphMany
    {
        return $this->morphMany(ShadowBan::class, 'modulable');
    }

    public function hasBan(string $type): bool
    {
        return $this->shadowBans()->where('type', $type)->exists();
    }

    public function setBan(string $type)
    {
        try{
            $this->shadowBans()->create([
                'type' => $type,
                'expires_at' => now()->addDays(30), //change default day
            ]);
        }catch(Exception $exception){
            Log::error("Error @ setBan: " . $exception->getMessage());
            throw new Exception('Error setting ban: ' . $exception->getMessage());
        }
    }
}
