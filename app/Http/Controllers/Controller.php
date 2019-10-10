<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $appConfig;
    protected $user;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            view()->share('user', $this->user);
            view()->share('authenticatedUser', $this->user);
            return $next($request);
        });

        config()->set('siteSettings',  $this->appConfig);
        view()->share('appConfig', $this->appConfig);
    }

}
