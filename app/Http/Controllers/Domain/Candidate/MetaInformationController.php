<?php

namespace App\Http\Controllers\Domain\Candidate;

use App\Supports\ApiReturnResponse;

class MetaInformationController extends BaseController
{
    public function languageProficiency()
    {
        return ApiReturnResponse::success([
            'beginner',
            'advanced',
            'expert',
        ]);
    }
}
