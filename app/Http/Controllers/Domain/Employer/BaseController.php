<?php

namespace App\Http\Controllers\Domain\Employer;

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Employer\EmployerUser;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected ?EmployerUser $user;

    protected ?EmployerAccess $employerAccess;

    protected ?Employer $employer;

    public function __construct()
    {
        $this->middleware(function(Request $request, $next){
            if ( $request->user() ){
                $this->user = $request->user();

                $this->employerAccess = $this->user->employerAccess()->first();

                $this->employer = $this->employerAccess->employer;
            }

            return $next($request);
        });
    }
}
