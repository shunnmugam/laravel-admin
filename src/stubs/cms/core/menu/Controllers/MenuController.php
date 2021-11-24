<?php

namespace cms\core\menu\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Arr;

//helpers
use DB;
use User;
use Session;

//models
use cms\core\user\Models\UserModel;
use cms\core\usergroup\Models\UserGroupModel;
use cms\core\page\Models\PageModel;
use cms\core\menu\Models\AdminMenuPermissionModel;
use cms\core\menu\Models\AdminMenuModel;

class MenuController extends Controller
{


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            \CGate::SuperAdminonly();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('menu::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $group = UserGroupModel::where('status', 1)->orderBy('group', 'Asc')->pluck("group", "id");
        return view('menu::admin.edit', ['layout' => 'create', 'group' => $group]);
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

        $Hash = Hash::make($request->password);
        $data->password = $Hash;
        $data->status = $request->status;


        if ($data->save()) {
            $usertypemap = new UserGroupMapModel;
            $usertypemap->user_id = $data->id;
            $usertypemap->group_id    = $request->group;
            $usertypemap->save();

            $msg = "Users save successfully";
            $class_name = "success";
        } else {
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
        $group = UserGroupModel::where('status', 1)->orderBy('group', 'Asc')->pluck("group", "id");
        return view('user::admin.edit', ['layout' => 'edit', 'group' => $group, 'data' => $data]);
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
            'email' => 'required|unique:users,email,' . $id,
            'password' => 'sometimes|same:password2',
            'password2' => 'sometimes',
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
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
        if ($request->password) {
            $Hash = Hash::make($request->password);
            $data->password = $Hash;
        }
        $data->status = $request->status;


        if ($data->save()) {
            UserGroupMapModel::where('user_id', '=', $id)->delete();
            $usertypemap = new UserGroupMapModel;
            $usertypemap->user_id = $data->id;
            $usertypemap->group_id    = $request->group;
            $usertypemap->save();

            $msg = "Users save successfully";
            $class_name = "success";
        } else {
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
    public function destroy($id, Request $request)
    {
        print_r($request->selected_users);
        exit;
    }

    /*
     * *********************additional methods*************************
     */

    /*
     * get user data
     */
    public function getData(Request $request)
    {
        $sTart = ctype_digit($request->get('start')) ? $request->get('start') : 0;
        //$sTart = 0;
        DB::statement(DB::raw('set @rownum=' . $sTart));


        $data = UserModel::select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), "users.id as id", "name", "username", "email", "mobile", "user_groups.group", DB::raw('(CASE WHEN ' . DB::getTablePrefix() . 'users.status = "0" THEN "Disabled" ELSE "Enabled" END) AS status'), "images")
            ->join('user_group_map', 'user_group_map.user_id', '=', 'users.id')
            ->join('user_groups', 'user_groups.id', '=', 'user_group_map.group_id')
            ->get();

        $datatables = Datatables::of($data)
            //->addColumn('check', '{!! Form::checkbox(\'selected_users[]\', $id, false, array(\'id\'=> $rownum, \'class\' => \'catclass\')); !!}{!! Html::decode(Form::label($rownum,\'<span></span>\')) !!}')
            ->addColumn('check', function ($data) {
                if ($data->id != '1')
                    return $data->rownum;
                else
                    return '';
            })
            ->addColumn('actdeact', function ($data) {
                if ($data->id != '1') {
                    $statusbtnvalue = $data->status == "Enabled" ? "<i class='glyphicon glyphicon-remove'></i>&nbsp;&nbsp;Disable" : "<i class='glyphicon glyphicon-ok'></i>&nbsp;&nbsp;Enable";
                    return '<a class="statusbutton btn btn-default" data-toggle="modal" data="' . $data->id . '" href="">' . $statusbtnvalue . '</a>';
                } else
                    return '';
            })
            ->addColumn('action', function ($data) {
                return '<a class="editbutton btn btn-default" data-toggle="modal" data="' . $data->id . '" href="' . route("user.edit", $data->id) . '" ><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit</a>';
                //return $data->id;
            });



        // return $data;
        if (count((array) $data) == 0)
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

        if (!empty($request->selected_users)) {
            if (($key = array_search(1, $request->selected_users)) !== false) {
                $request->selected_users = Arr::except($request->selected_users, array($key));
            }

            $obj = new UserModel;
            foreach ($request->selected_users as $k => $v) {

                //echo $v;
                if ($item = $obj->find($v)) {
                    $item->status = $request->action;
                    $item->save();
                }
            }
        }

        Session::flash("success", "User Status changed Successfully!!");
        return redirect()->back();
    }

    function getMenuUrl()
    {
        $pages = PageModel::where('status', 1)->select('title', 'url', 'id')->get();

        if (count((array) $pages) == 0)
            $pages = array();

        return json_encode(array('status' => 1, 'pages' => $pages));
    }

    function menuAssign()
    {
        $groups = UserGroupModel::get();

        $permissions = AdminMenuPermissionModel::get();
        $permission = array();
        foreach ($permissions as $datas) {
            $permission[$datas->group_id][$datas->menu_id] = $datas->status;
        }

        $menus = AdminMenuModel::get();

        return view('wmenu::admin.menu_assign', ['permission' => $permission, 'groups' => $groups, 'menus' => $menus]);
    }

    function doMenuAssign(Request $request)
    {
        foreach ($request->role as $group_id => $group) {
            foreach ($group as $menu_id => $role) {

                $obj = AdminMenuPermissionModel::where('menu_id', $menu_id)
                    ->where('group_id', $group_id)->first();
                if (count((array) $obj) == 0)
                    $obj = new AdminMenuPermissionModel;

                $obj->menu_id = $menu_id;
                $obj->group_id = $group_id;
                $obj->status = $role;
                $obj->save();
            }
        }
        return redirect()->back();
    }
}
