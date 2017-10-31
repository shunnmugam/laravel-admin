<?php
namespace cms\core\menu\helpers;

//helpers
use Auth;
use Cms;
use User;
//models
use cms\core\menu\Models\AdminMenuGroupModel;
use cms\core\menu\Models\AdminMenuModel;
use cms\core\menu\Models\AdminMenuPermissionModel;

abstract class Menu
{
    protected static $menu_groups;
    protected static $menus;

    protected static $menulist;
    function __construct()
    {

    }

    public static function registerMenu()
    {
        $path = Cms::allModulesPath();
        self::$menu_groups = array();
        self::$menus = array();
        $group_id = array();
        foreach ($path as $module) {
            if (file_exists($module . DIRECTORY_SEPARATOR . 'menu.xml')) {
                $xml = simplexml_load_file($module . DIRECTORY_SEPARATOR . 'menu.xml');
                // print_r(json_decode(json_encode($xml)));echo "<br><br>";
                //group loop
                foreach ($xml->group as $group_key => $group) {
                    $name =  (string) $xml->group['name'];
                    $group_order = (isset($group->attributes()['order'])) ? (string) $group->attributes()['order'] : $group_key;
                    $menugroup = AdminMenuGroupModel::where('name',$name)
                        ->where('parent',0)
                        ->first();
                    if(count($menugroup)==0)
                        $menugroup = new AdminMenuGroupModel;

                    $menugroup->name = $name;
                    $menugroup->order = $group_order;
                    $menugroup->save();
                    $parent_id = $menugroup->id;
                    $group_id[] = $parent_id;
                    if(isset($group->menugroup)){
                        foreach ($group->menugroup as $menu_key => $menus) {
                            self::registerMenugroup($menus,$parent_id,$menu_key);
                        }
                    }

                    if(isset($group->menu))
                        self::registerMenus($group->menu,$parent_id);

                }
            }
        }
        AdminMenuGroupModel::whereNotIn('id',$group_id)->where('parent',0)->delete();
        AdminMenuGroupModel::whereNotIn('id',self::$menu_groups)->where('parent','!=',0)->delete();
        AdminMenuModel::whereNotIn('id',self::$menus)->delete();
        //exit;
    }

    protected static function registerMenugroup($menus,$parent_id,$menu_key)
    {
        $name = (string)$menus['name'];
        $menu_order = (isset($menus['order'])) ? (string)$menus['order'] : $menu_key;
        $menugroup = AdminMenuGroupModel::where('name',$name)
            ->where('parent',$parent_id)
            ->first();
        if(count($menugroup)==0)
            $menugroup = new AdminMenuGroupModel;

        $menugroup->name = $name;
        $menugroup->order = $menu_order;
        $menugroup->parent = $parent_id;
        $menugroup->icon = (string)$menus['icon'];
        $menugroup->save();
        $parent_id = $menugroup->id;
        self::$menu_groups[] = $parent_id;
        if(isset($menus->menu))
            self::registerMenus($menus->menu,$parent_id);

        if(isset($menus->menugroup)){
            foreach ($menus->menugroup as $menu_key => $menus) {
                self::registerMenugroup($menus,$parent_id,$menu_key);
            }
        }

    }

    protected static function registerMenus($menus,$parent_id)
    {
        foreach ($menus as $menu) {
            $menumodel = AdminMenuModel::where('name',$menu['name'])
                ->where('group_id',$parent_id)
                ->first();
            if(count($menumodel)==0)
                $menumodel = new AdminMenuModel;

            $menumodel->name = $menu['name'];
            $menumodel->group_id = $parent_id;
            $menumodel->url = isset($menu['route']) ? $menu['route'] : $menu['url'];
            $menumodel->is_url = isset($menu['is_url']) ? $menu['is_url'] : 0;
            $menumodel->icon = $menu['icon'];
            $menumodel->save();

            self::$menus[] = $menumodel->id;
        }
    }

    static function getAdminMenu()
    {
        $menugroup = AdminMenuGroupModel::with('menu')
                ->where('status','=',1)
                ->orderBy('order','ASC')
                ->get()->toArray();
        $current_user_group = User::getUser()->group[0]['id'];

        if(User::isSuperAdmin()==false){
            $permissions = AdminMenuPermissionModel::get();
            $permission = array();
            foreach ($permissions as $datas)
            {
                $permission[$datas->group_id][$datas->menu_id] = $datas->status;
            }

            foreach ($menugroup as $groupkey => $group)
            {
                foreach ($group['menu'] as $menu_key => $menu)
                {
                   if($permission[$current_user_group][$menu['id']]==0)
                   {
                       unset($menugroup[$groupkey]['menu'][$menu_key]);
                   }
                }
            }
        }

        $return_array = self::buildTree($menugroup);
        if(User::isSuperAdmin()==false) {
            foreach ($return_array as $key_n => $gorup_n) {
                if (count($gorup_n['menu']) == 0 && !isset($gorup_n['group'])) {
                    unset($return_array[$key_n]);
                }
            }
        }
        return $return_array;
    }

    protected static function buildTree(array $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent'] == $parentId) {
                $children = self::buildTree($elements, $element['id']);
                if ($children) {
                    $element['group'] = $children;
                }
                if(count($element['menu'])!=0 || $parentId==0)
                    $branch[] = $element;
            }
        }

        return $branch;
    }

    static function getAdminMenuOnly()
    {
        return  AdminMenuModel::get()->toArray();
    }

    static function get($menu)
    {

    }




}