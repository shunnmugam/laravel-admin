<?php

namespace cms\core\admin\Controllers;

use User;
use Hash;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;

//models
use cms\core\user\Models\UserModel;

use App\Http\Controllers\Controller;

class AdminAuth extends Controller
{
    /*
     * back end login
     */
    public function login()
    {
        return view('admin::login');
    }
    /*
     * back end do login
     */
    public function dologin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|exists:users,username|max:191',
            'password' => 'required',
        ]);

        $user = User::check(['username'=>$request->username,'password'=>$request->password]);

        if($user) {
            $users = UserModel::where('username','=',$request->username)->first();
            Session::put(['ACTIVE_USER' => strval($users->id)
                ,'ACTIVE_USERNAME' => $users->username,
                'ACTIVE_GROUP' => 'Super Admin',
                'ACTIVE_EMAIL' => $users->email,
                'ACTIVE_MOBILE' => $users->mobile,
                'ACTIVE_USERIMAGE' => $users->images]);
            //change offline to online
            $users->online = 1;
            $users->ip = request()->ip();
            $users->lastactive = Carbon::now();
            $users->save();
            return redirect()->route('backenddashboard');
        }
        else
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors(['Wrong Information']);
    }
    /*
     * back end dashboard
     */
    public function dashboard()
    {
        return view('admin::main');
    }
    /*
     * back end log out
     *
     */
    public function logout(Request $request)
    {
        $user = User::getUser();
        $users = UserModel::find($user->id);

        //change online to offline
        $users->online = 1;
        $users->ip = request()->ip();
        $users->lastactive = Carbon::now();
        $users->save();

        $request->session()->flush();

        Session::flash("success","Logout Successfull");
        return redirect('administrator/login');
    }

}
