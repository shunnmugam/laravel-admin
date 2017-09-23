<?php

namespace cms\core\user\Middleware;

use Closure;
//helpers

use User;

//models
use cms\core\role\Models\PermissionModel;
class UserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!User::isLogin())
        {
            return redirect()->route('login');
        }


        return $next($request);
    }
}
