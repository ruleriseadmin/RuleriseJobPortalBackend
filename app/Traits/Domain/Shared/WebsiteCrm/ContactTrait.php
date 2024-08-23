<?php

namespace App\Traits\Domain\Shared\WebsiteCrm;

trait ContactTrait
{
    public static function contact()
    {
        return [
            'email' => 'email',
            'phone_number' => 'phone_number',
            'instagram' => 'instagram',
            'facebook' => 'facebook',
            'linkedin' => 'linkedin',
            'whatsapp' => 'whatsapp',
        ];
    }
}
