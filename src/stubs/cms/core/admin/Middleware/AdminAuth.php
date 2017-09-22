<?php

namespace cms\core\admin\Middleware;

use Closure;
use Session;
use User;
use CGate;
class AdminAuth
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
        if(!ctype_digit(Session::get('ACTIVE_USER')) || !filter_var(Session::get('ACTIVE_EMAIL'), FILTER_VALIDATE_EMAIL)){
            return redirect('administrator/login');

        }
        if(CGate::allows('Backend Access')!=true)
        {
            $request->session()->flush();
            Session::flash("error","Access Denied");
            return redirect('administrator/login');
        }

        return $next($request);
    }

}
