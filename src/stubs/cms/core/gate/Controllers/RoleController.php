<?php
namespace cms\core\gate\Controllers;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

//models
use cms\core\usergroup\Models\UserGroupModel;
use cms\core\module\Models\ModuleModel;
use cms\core\gate\Models\HasPermissionModel;

use CGate;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            CGate::SuperAdminonly();
            return $next($request);
        });

    }

    public function getRoles()
    {
        CGate::registerPermission();
       //echo  \CGate::allows('create-blog');
        $module = ModuleModel::with('permissions')->get();
        $groups = UserGroupModel::get();


        /*
        $roles = RolesModel::with('module')->get();

        foreach ($roles as $role)
        {
            $data[$role->module->name][] = $role;
        }
        //print_r($data);exit;

        $groups = UserGroupModel::get();
        $permissions = PermissionModel::get();
        $permission = array();
        foreach ($permissions as $datas)
        {
            $permission[$datas->group_id][$datas->role_id] = $datas->status;
        }

        return view('gate::admin.roles',['data'=>$data,'groups'=>$groups,'permission'=>$permission]);
        */

        $permissions = HasPermissionModel::get();
        $permission = array();
        foreach ($permissions as $datas)
        {
            $permission[$datas->group_id][$datas->permission_id] = $datas->status;
        }


        return view('gate::admin.gates',['data'=>'','groups'=>$groups,'module'=>$module,'permission'=>$permission]);
    }
    /*
     * save function
     */
    public function save(Request $request)
    {
        foreach($request->role as $group_id => $group)
        {
            foreach ($group as $role_id => $role) {

                $obj = HasPermissionModel::where('permission_id',$role_id)
                                ->where('group_id',$group_id)->first();
                if(count($obj)==0)
                    $obj = new HasPermissionModel;

                $obj->permission_id = $role_id;
                $obj->group_id = $group_id;
                $obj->status = $role;
                $obj->save();
            }
        }

        return redirect('administrator/roles-permissions');

    }

}
