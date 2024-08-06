<?php

namespace App\Http\Controllers\Domain\Admin;

use App\Models\Domain\Admin\AdminUser;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected ?AdminUser $user;

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
