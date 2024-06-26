<?php

namespace App\Http\Controllers\Domain\Employer\Auth;

use App\Actions\Domain\Shared\Auth\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\Employer\Auth\LoginRequest;
use Illuminate\Http\Request;

class LoginController
{
    public function store(LoginRequest $request)
    {
        //@todo login action
        (new LoginAction)->execute('employer', $request->validated());

        //@todo send response
    }
}
