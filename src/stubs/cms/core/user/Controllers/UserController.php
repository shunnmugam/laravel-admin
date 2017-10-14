<?php

namespace cms\core\user\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

use Yajra\Datatables\Facades\Datatables;

//helpers
use DB;
use User;
use Session;
use Cms;
use Roles;
use Carbon\Carbon;
use Plugins;
use Configurations;
use Event;
use Mail;
//events
use cms\core\user\Events\UserRegisteredEvent;
//models
use cms\core\user\Models\UserModel;
use cms\core\usergroup\Models\UserGroupModel;
use cms\core\usergroup\Models\UserGroupMapModel;

//mail
use cms\core\user\Mail\ForgetPasswordMail;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $group = UserGroupModel::where('status',1)->orderBy('group','Asc')->pluck("group","id");
        return view('user::admin.edit',['layout'=>'create','group'=>$group]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users,email|max:191',
            'password' => 'required|same:password2',
            'password2' => 'required',
            'name' => 'required',
            'username' => 'required|unique:users,username|max:191',
            'mobile' => 'required|min:9|max:15',
            'group' => 'required|exists:user_groups,id',
            'status' => 'required'
        ]);


        $data = new UserModel;
        $data->name = mb_convert_case($request->name, MB_CASE_TITLE, "UTF-8");
        $data->username  = $request->username;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->images = $request->image;

        $Hash=Hash::make($request->password);
        $data->password = $Hash;
        $data->status = $request->status;


        if($data->save()){
            $usertypemap = new UserGroupMapModel;
            $usertypemap->user_id = $data->id;
            $usertypemap->group_id    = $request->group;
            $usertypemap->save();

            $msg = "Users save successfully";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect(route('user.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo "hai";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = UserModel::with('group')->find($id);
        //print_r($data->group[0]->group);exit;
        $group = UserGroupModel::where('status',1)->orderBy('group','Asc')->pluck("group","id");
        return view('user::admin.edit',['layout'=>'edit','group'=>$group,'data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'required|unique:users,email,'.$id,
            'password' => 'sometimes|same:password2',
            'password2' => 'sometimes',
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$id,
            'mobile' => 'required|min:9|max:15',
            'group' => 'required|exists:user_groups,id',
            'status' => 'required'
        ]);


        $data = UserModel::find($id);
        $data->name = mb_convert_case($request->name, MB_CASE_TITLE, "UTF-8");
        $data->username  = $request->username;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->images = $request->image;
        if($request->password) {
            $Hash = Hash::make($request->password);
            $data->password = $Hash;
        }
        $data->status = $request->status;


        if($data->save()){
            UserGroupMapModel::where('user_id','=',$id)->delete();
            $usertypemap = new UserGroupMapModel;
            $usertypemap->user_id = $data->id;
            $usertypemap->group_id    = $request->group;
            $usertypemap->save();

            $msg = "Users save successfully";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect(route('user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        if(!empty($request->selected_users))
        {
            if(($key = array_search(1, $request->selected_users)) !== false) {
                $request->selected_users = array_except($request->selected_users, array($key));
            }

            $delObj = new UsersModel;
            foreach ($request->selected_users as $k => $v) {

                //echo $v;
                if($delItem = $delObj->find($v))
                {
                    $delItem->delete();

                }

            }

        }

        Session::flash("success","User Deleted Successfully!!");
        return redirect()->route("user.index");
    }

    /*
     * *********************additional methods*************************
     */

    /*
     * get user data
     */
    public function getData(Request $request)
    {
        $sTart = ctype_digit($request->get('start')) ? $request->get('start') : 0 ;
        //$sTart = 0;
        DB::statement(DB::raw('set @rownum='.$sTart));


        $data = UserModel::select(DB::raw('@rownum  := @rownum  + 1 AS rownum'),"users.id as id","name","username","email","mobile","user_groups.group",DB::raw('(CASE WHEN '.DB::getTablePrefix().'users.status = "0" THEN "Disabled" ELSE "Enabled" END) AS status'),"images")
            ->join('user_group_map', 'user_group_map.user_id', '=', 'users.id')
            ->join('user_groups', 'user_groups.id', '=', 'user_group_map.group_id')
            ->get();

        $datatables = Datatables::of($data)
            //->addColumn('check', '{!! Form::checkbox(\'selected_users[]\', $id, false, array(\'id\'=> $rownum, \'class\' => \'catclass\')); !!}{!! Html::decode(Form::label($rownum,\'<span></span>\')) !!}')
            ->addColumn('check', function($data) {
                if($data->id != '1')
                    return $data->rownum;
                else
                    return '';
            })
            ->addColumn('actdeact', function($data) {
                if($data->id != '1'){
                    $statusbtnvalue=$data->status=="Enabled" ? "<i class='glyphicon glyphicon-remove'></i>&nbsp;&nbsp;Disable" : "<i class='glyphicon glyphicon-ok'></i>&nbsp;&nbsp;Enable";
                    return '<a class="statusbutton btn btn-default" data-toggle="modal" data="'.$data->id.'" href="">'.$statusbtnvalue.'</a>';
                }
                else
                    return '';
            })
            ->addColumn('action',function($data){
                return '<a class="editbutton btn btn-default" data-toggle="modal" data="'.$data->id.'" href="'.route("user.edit",$data->id).'" ><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit</a>';
                //return $data->id;
            });



        // return $data;
        if(count($data)==0)
            return [];

        return $datatables->make(true);
    }

    /*
     * user bulk action
     * eg : trash,enabled,disabled
     * delete is destroy function
     */
    function statusChange(Request $request)
    {

        if(!empty($request->selected_users))
        {
            if(($key = array_search(1, $request->selected_users)) !== false) {
                $request->selected_users = array_except($request->selected_users, array($key));
            }

            $obj = new UserModel;
            foreach ($request->selected_users as $k => $v) {

                //echo $v;
                if($item = $obj->find($v))
                {
                    $item->status = $request->action;
                    $item->save();

                }

            }

        }

        Session::flash("success","User Status changed Successfully!!");
        return redirect()->back();
    }
    /*
     * user registration from frond end using ajax
     */
    public  function ajaxRegister(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|unique:users,email|max:191',
            'password' => 'required|min:4',
            'username' => 'required|unique:users,username|max:191',
        ]);

        $data = new UserModel;
        $data->name = mb_convert_case($request->username, MB_CASE_TITLE, "UTF-8");
        $data->username  = $request->username;
        $data->email = $request->email;

        $Hash=Hash::make($request->password);
        $data->password = $Hash;

        $config = @Configurations::getParm('user',1);
        $verification_type = @$config->register_verification;
        if($verification_type==0)
            $data->status = 1;
        else
            $data->status = 0;

        $data->remember_token = md5(time() . rand()); ;


        if($data->save()){
            $usertypemap = new UserGroupMapModel;
            $usertypemap->user_id = $data->id;
            $usertypemap->group_id    = 2;
            $usertypemap->save();
            Event::fire(new UserRegisteredEvent($data->id));
            $msg = "Users save successfully,Please Chack Your Mail Id";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
        }
        $url = @Configurations::getParm('user',1)->login_redirection_url;
        if(!$url)
            $url = route('home');
        else
            $url = url('/').$url;

        return ['status'=>1,'message'=>$msg,'url'=>$url];
    }
    /*
     * user registration from frond end
     */
    public  function register(Request $request)
    {   if(@Configurations::getParm('user',1)->allow_user_registration!=1)
        {
            Session::flash("error","Register is blocked");
            return redirect()->route('home');
        }
        $this->validate($request, [
            'email' => 'required|unique:users,email|max:191',
            'password' => 'required|min:4',
            'username' => 'required|unique:users,username|max:191',
        ]);

        $data = new UserModel;
        $data->name = mb_convert_case($request->username, MB_CASE_TITLE, "UTF-8");
        $data->username  = $request->username;
        $data->email = $request->email;

        $Hash=Hash::make($request->password);
        $data->password = $Hash;
        $config = @Configurations::getParm('user',1);
        $verification_type = @$config->register_verification;
        if($verification_type==0)
            $data->status = 1;
        else
            $data->status = 0;

        $data->remember_token = md5(time() . rand());


        if($data->save()){
            $usertypemap = new UserGroupMapModel;
            $usertypemap->user_id = $data->id;
            $usertypemap->group_id    = 2;
            $usertypemap->save();
            Event::fire(new UserRegisteredEvent($data->id));
            $msg = "Users save successfully,Please Chack Your Mail Id";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
        }


        return ['status'=>1,'message'=>$msg];
    }
    /*
     * user login using ajax
     */
    public function ajaxLogin(Request $request)
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
                'ACTIVE_EMAIL' => $users->email
                ]);
            //change offline to online
            $users->online = 1;
            $users->ip = request()->ip();
            $users->lastactive = Carbon::now();
            $users->save();

            $url = @Configurations::getParm('user',1)->login_redirection_url;

            if(!$url)
                $url = route('home');
            else
                $url = url('/').$url;

            return ['status'=>1,'message'=>'Success','url'=>$url];

        }
        else
            return ['status'=>0,'message'=>'user name and password is missmatch'];
    }
    /*
     * user login
     */
    public function login(Request $request)
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
                'ACTIVE_EMAIL' => $users->email
                ]);
            //change offline to online
            $users->online = 1;
            $users->ip = request()->ip();
            $users->lastactive = Carbon::now();
            $users->save();

            $url = @Configurations::getParm('user',1)->login_redirection_url;

            if(!$url)
                $url = route('home');
            else
                $url = url('/').$url;

            Session::flash("success","Login Successfull");
            return redirect($url);


        }
        else
        {
            Session::flash("error","user name or password is missmatch");
            return redirect()->back();
        }
    }
    /*
     * activate user
     */
    public function activate($token)
    {
        $users = UserModel::where('remember_token','=',$token)->first();
        if(count($users)) {
            $users->status = 1;
            $users->remember_token='';
            $users->save();
            Session::flash("success","Account activated Successfully");
        }
        else
            Session::flash("error","Wrong Datas");

        return redirect()->route('home');

    }
    /*
     * forget password
     */
    public function forgetPassword(Request $request)
    {
        $users = UserModel::with('group')->where('email','=',$request->email)->first();
        if(count($users)) {
            $user_group = User::getUserGroup($users->id);

            if(in_array(1,$user_group))
            {
                return ['status'=>0,'message'=>'Restricted Area'];
            }
            $users->remember_token= md5(time() . rand());
            $users->save();
            \CmsMail::setMailConfig();
            Mail::to($users->email)->queue(new ForgetPasswordMail($users));
            Session::flash("success","Please Check Your Mail");

            if($request->ajax()) {
                return ['status'=>1,'message'=>'Please Check Your Mail'];
            }
        }
        else
            Session::flash("error","Wrong Email");

        if($request->ajax()) {
            return ['status'=>0,'message'=>'Wrong Email'];
        }

        return redirect()->route('home');
    }
    /*
     * verifyForgetPassword from mail
     */
    public function verifyForgetPassword($token)
    {
        $users = UserModel::where('remember_token','=',$token)->first();
        if(count($users)) {
            return view('user::site.password_change',['token'=>$token]);
        }
        else
            Session::flash("error","Wrong Datas,Please Try agin Later");

        return redirect()->route('home');
    }
    public function dochangePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|same:re-enter-password',
            're-enter-password' => 'required',
            'token' => 'required'
        ]);

        $users = UserModel::where('remember_token','=',$request->token)->first();
        if(count($users)) {
            $users->remember_token='';
            $Hash=Hash::make($request->password);
            $users->password = $Hash;
            $users->save();
            Session::flash("success","Password Update Successfully");
        }
        else
            Session::flash("error","Wrong Datas,Please Try agin Later");

        return redirect()->route('home');

    }
    /*
     * user logout
     */
    public function logout(Request $request)
    {
        $user = User::getUser();
        if(isset($user->id)){
        $users = UserModel::find($user->id);

        //change online to offline
        $users->online = 1;
        $users->ip = request()->ip();
        $users->lastactive = Carbon::now();
        $users->save();
        }
        $request->session()->flush();

        $url = @Configurations::getParm('user',1)->logout_redirection_url;
        if(!$url)
            $url = '/';
        Session::flash("success","Logout Successfull");
        return redirect($url);

    }
    /*
     * my account page
     */
    public function account()
    {
        $user = User::getUser();

        return view('user::site.user',['data'=>$user]);
    }
    /*
     * update account
     */
    public function updateAccount(Request $request)
    {
        $id = User::getUser()->id;
        $this->validate($request, [
            'email' => 'required|unique:users,email,'.$id,
            'password' => 'sometimes',
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$id,
            'mobile' => 'min:9|max:15',
        ]);

        $data = UserModel::find($id);
        $data->name = mb_convert_case($request->name, MB_CASE_TITLE, "UTF-8");
        $data->username  = $request->username;
        $data->email = $request->email;
        if($request->mobile)
        $data->mobile = $request->mobile;
        if($request->image) {
            $user_obj = new User;
            $img = $user_obj->imageCreate($request->image,'user');
            $data->images = $img;
        }
        if($request->password) {
            $Hash = Hash::make($request->password);
            $data->password = $Hash;
        }


        if($data->save()){
            $msg = "Account updated successfully";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect()->back();
    }
    /*
     * configurations option
     */
    public function getConfigurationData()
    {
        $group = UserGroupModel::where('status',1)->where('id','!=',1)->orderBy('group','Asc')->pluck("group","id");

        return ['user_group'=>$group];
    }

}
