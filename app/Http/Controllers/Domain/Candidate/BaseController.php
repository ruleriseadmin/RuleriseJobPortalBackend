<?php

namespace App\Http\Controllers\Domain\Candidate;

use Illuminate\Routing\Controller;
use App\Models\Domain\Candidate\User;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected ?User $user;

    public function __construct()
    {
        $this->middleware(function(Request $request, $next){
            if ( $request->user() ){
                $this->user = $request->user();
            }

            return $next($request);
        });
    }
}
