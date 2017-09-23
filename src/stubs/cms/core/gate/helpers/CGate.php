<?php
namespace cms\core\gate\helpers;

use Cms;
use Module;
use User;
//models
use cms\core\gate\Models\PermissionModel;
use cms\core\gate\Models\HasPermissionModel;
class CGate
{
    public static function registerPermission()
    {
        $modules = Cms::allModules();

        //print_r($modules);exit;
        $temp_permissions = ['view','create','edit','delete'];

        $id_array = array();
        foreach ($modules as $module)
        {
            $common_permissions = ['view','create','edit','delete'];
            $skip = 0;
            if(isset($module['permissions']))
            {
                $permission_array = $module['permissions'];
               if(isset($permission_array['status']) && $permission_array['status']==false)
                    $skip = 1;

               if(isset($permission_array['except']))
               {
                   foreach ($permission_array['except'] as $except)
                   {
                       if(($key = array_search($except, $common_permissions)) !== false) {
                           unset($common_permissions[$key]);
                       }
                   }
               }
               if(isset($permission_array['add']))
               {
                   foreach ($permission_array['add'] as $add)
                   {
                       $common_permissions[] = $add;
                   }
               }
            }
            if($skip==0) {
                foreach ($common_permissions as $common_permission) {
                    $name = (in_array($common_permission,$temp_permissions) ? $common_permission . '-' . $module['name'] : $common_permission);
                    $obj = PermissionModel::where('name', $name)->first();
                    if (count($obj) == 0)
                        $obj = new PermissionModel;

                    $obj->name = $name;
                    $type = ($module['type'] == 'core') ? 1 : 2;
                    $obj->module_id = Module::getId($module['name'], $type);
                    $obj->save();
                    $id_array[] = $obj->id;
                }
            }
        }

        //delete not avalable plugins
        PermissionModel::whereNotIn('id',$id_array)->delete();

    }


    /*
     * check permisiion
     */
    public static function allows($permission_name)
    {
        if(User::isSuperAdmin())
        {
            return true;
        }

        $permissions = PermissionModel::select('id')->where('name', $permission_name)->first();

        if(count($permissions)==0)
            return -1; //permission not found

        $permission_id = $permissions->id;

        $group_id = User::getUserGroup();

        if(!$group_id) {
            $group_id[] = 0;
        }

        $obj = HasPermissionModel::select('status')->where('permission_id',$permission_id)
                ->whereIn('group_id',$group_id)
                ->first();

        if(count($obj)!=0) {
            return ($obj->status == 1) ? true : false;
        }
        else {
            $obj = HasPermissionModel::select('status')->where('permission_id',$permission_id)
                ->first();
            if(count($obj)!=0)
                return false;
            else
                return true;
        }

    }
    /*
     * check permission if false means redirect to 403
     */
    public static function authorize($permission_name)
    {
        if(self::allows($permission_name)==false)
        {
            echo "Access Denied";
            exit;
        }
    }
    /*
     * check only for super admin
     */
    public static function SuperAdminonly()
    {
        if(!User::isSuperAdmin())
        {
            echo "Access Denied";
            exit;
        }

    }
    /*
     * resource controller check
     */
    public static function resouce($permission_group_name,$excepts=array())
    {
        $currentAction = \Route::currentRouteAction();
        list($controller, $method) = explode('@', $currentAction);
        $resource_array = [
            'index'=>'view-'.$permission_group_name,
            'create'=>'create-'.$permission_group_name,
            'store'=>'create-'.$permission_group_name,
            'show'=>'view-'.$permission_group_name,
            'edit'=>'edit-'.$permission_group_name,
            'update'=>'edit-'.$permission_group_name,
            'destroy'=>'delete-'.$permission_group_name,
        ];
        foreach ($excepts as $except )
        {
            unset($resource_array[$except]);
        }
        if(isset($resource_array[$method]))
            self::authorize($resource_array[$method]);
    }

}