<?php
namespace Ramesh\Cms\Controller;

use App\Http\Controllers\Controller;
use File;

use Ramesh\Cms\Generators\FileGenerator;
use Html;
use Module;



class CmsController extends Controller
{
    /*
     * url
     */
    protected $url;
    public function __construct()
    {

    }

    public function module($modulename)
    {
        return new ModuleController($modulename);
    }

    /*
     * get cms path
     */
    public function getPath()
    {
        return $this->getConfig()['path'];
    }

    /******************get modules values ***********/
    /*
     * get modules path
     */
    public function getModulesPath()
    {
        return $this->getConfig()['module']['path'];
    }
    /*
     * get core modules path
     */
    public function getModulesCorePath()
    {
        return $this->getConfig()['module']['core_path'];
    }/*
     * get local modules path
     */
    public function getModulesLocalPath()
    {
        return $this->getConfig()['module']['local_path'].DIRECTORY_SEPARATOR.$this->getCurrentTheme();
    }
    /*
     * get module configuration file
     */
    public function getModulesConfigurationName()
    {
        return $this->getConfig()['module']['configuration'];
    }

    /*
     * get modules list
     */
    public function allModules()
    {
        $modules = $this->allModulesPath();
        //print_r($modules);exit;

        $json = array();

        foreach($modules as $module)
        {
            $path_arry = explode(DIRECTORY_SEPARATOR,$module);
            $current_module = $path_arry[count($path_arry)-1];
            $json_file = json_decode(file_get_contents($module.DIRECTORY_SEPARATOR.$this->getModulesConfigurationName()), true);
           // $path =array("path"=>$this->getPath().DIRECTORY_SEPARATOR.$this->getModulesCorePath().DIRECTORY_SEPARATOR.$module);
            $path = array("path"=>$module);
           // print_r($json_file);exit;

            foreach ($json_file['providers'] as $key => $provider)
            {
                if($json_file['type'] == 'core') {
                    $module_path = $this->getModulesCorePath();
                    $json_file['providers'][$key] = $this->getPath() . DIRECTORY_SEPARATOR . $module_path . DIRECTORY_SEPARATOR . $current_module . DIRECTORY_SEPARATOR . $provider;
                }else {
                    $module_path = 'local';//$this->getModulesLocalPath();
                $json_file['providers'][$key] = $this->getPath().DIRECTORY_SEPARATOR.$current_module.DIRECTORY_SEPARATOR.$provider;
                }


            }
            $json[] =array_merge($json_file,$path);
        }
        //print_r($json);exit;

        return $json;
    }
    /*
     * get core modules path
     */
    public function getCoreModulePath($basepath=true)
    {
        $path = File::directories( base_path().DIRECTORY_SEPARATOR.$this->getPath().DIRECTORY_SEPARATOR.$this->getModulesCorePath());
        if(!$basepath)
            $path = str_replace(base_path(), '', $path);
        return $path;
    }
    /*
     * get local modules path
     */
    public function getLocalModulePath($basepath=true)
    {
        $path = File::directories(base_path().DIRECTORY_SEPARATOR.$this->getPath().DIRECTORY_SEPARATOR.$this->getModulesLocalPath());
        if(!$basepath)
            $path = str_replace(base_path(), '', $path);
        return $path;
    }
    /*
     * get allmodule path
     */
    public function allModulesPath($basepath=true)
    {
        $core = $this->getCoreModulePath($basepath);
        $local = $this->getLocalModulePath($basepath);

        return array_merge($core,$local);
    }
    /*
     * get modules composer json
     */
    public function allModulesComposer()
    {
        $modules = $this->allModulesPath();

        $json = array();

        foreach($modules as $module)
        {
            $json[] = json_decode(file_get_contents($module.DIRECTORY_SEPARATOR.'composer.json'), true);

        }

        return $json;
    }
    /*
     * get all modules providers name
     */
    public function allModuleProvider()
    {
       // print_r($this->allModules());exit;
        return call_user_func_array('array_merge', array_column($this->allModules(), 'providers'));
    }
    /*
     * get all modules helper
     */
    public function allModulesHelpers()
    {
        return call_user_func_array('array_merge', array_column($this->allModules(), 'helpers'));
    }

    /**********get configuration values*****************/
    /*
     *
     */
    /*
     * get over all config
     */
    public function getConfig()
    {
        return config('cms');
    }

    public function getModuleConfig()
    {
        return $this->getConfig()['module'];
    }


    /**************Theme ****************/
    public function getThemeConfig()
    {
        return $this->getConfig()['theme'];
    }
    public function getCurrentTheme()
    {
        return $this->getThemeConfig()['active'];
    }



    /**
     * return html script.
     *
     */
    public function script($url, $attributes = [], $secure = null)
    {
        return Html::script('skin/theme1/'.$url,$attributes,$secure);
    }

    /**
     * return html style
     */
    public function style($url, $attributes = [], $secure = null)
    {
        return Html::style('skin/theme1/'.$url,$attributes,$secure);
    }

    /*
     * get Roles
     */
    public function getRoles($module_name = false)
    {
        $config = $this->allModules();
        $result = array();
        foreach ($config as $module)
        {
            if(isset($module['roles'])) {
                $type = ($module['type'] == 'core') ? 1 : 2;
                $module_id = Module::getId($module['name'],$type);
                $result[$module['name']]['path'] = $module['path'];
                $result[$module['name']]['type'] = $type;
                $result[$module['name']]['id'] = $module_id;
                $result[$module['name']]['file'] = $module['roles'];
                $result[$module['name']]['roles'] = $module['path'].DIRECTORY_SEPARATOR.$module['roles'];
            }
        }
        //print_r($result);exit;
        return $result;
    }

    /*
     * get Roles
     */
    public function getPlugins($module_name = false)
    {
        $config = $this->allModules();
        $result = array();
        foreach ($config as $module)
        {
            if(isset($module['plugins'])) {
                $type = ($module['type'] == 'core') ? 1 : 2;
                $module_id = Module::getId($module['name'],$type);
                $result[$module['name']]['path'] = $module['path'];
                $result[$module['name']]['type'] = $type;
                $result[$module['name']]['id'] = $module_id;
                $result[$module['name']]['file'] = $module['plugins'];
                $result[$module['name']]['plugins'] = $module['path'].DIRECTORY_SEPARATOR.$module['plugins'];
            }
        }
       // print_r($result);exit;
        return $result;
    }
    /*
     * admin menu creation
     */
    /*
    public function createAdminMenu()
    {
        $path = $this->allModulesPath();
        $data = array();

        foreach ($path as $module)
        {
            if(file_exists($module.DIRECTORY_SEPARATOR.'menu.xml'))
            {
                $xml=simplexml_load_file($module.DIRECTORY_SEPARATOR.'menu.xml');
                //print_r(json_decode(json_encode($xml)));echo "<br><br>";
                //group loop
                foreach($xml->group as $group_key => $group)
                {
                    //set menu group order
                    $group_order = (isset($group->attributes()['order'])) ? (string) $group->attributes()['order'] : $group_key;
                    $data[(string)$group->attributes()['name']]['order'] =   $group_order;
                    //menugroup loop
                    foreach ($group->menugroup as $menu_key => $menus) {
                        //set menu order
                        $menu_order = (isset($menus['order'])) ? (string)$menus['order'] : $menu_key;
                        $data[(string)$group->attributes()['name']]['menugroup'][(string)$menus['name']]['order'] = $menu_order;
                        //menu loop
                        foreach ($menus as $menu)
                            $data[(string)$group->attributes()['name']]['menugroup'][(string)$menus['name']]['menu'][] = $menu;
                    }
                }
            }
        }
        $group_order1 = array();
        foreach ($data as $key => $value)
        {
            $group_order1[] = $value['order'];
            $menu_order1 = array();

            $menugroup_copy = $value['menugroup'];
            foreach ($value['menugroup'] as $menugroup)
            {
                $menu_order1[] = $menugroup['order'];
            }
            array_multisort($menu_order1, SORT_ASC,$menugroup_copy );
            $data[$key]['menugroup'] = $menugroup_copy;
        }
        array_multisort($group_order1, SORT_ASC, $data);
        //print_r($data);exit;
        return $data;
    }
    */

    /*
     * temprory methods
     */

    function makeController()
    {
        $FileGenerator = new FileGenerator;
        $FileGenerator
            ->setPath(base_path().DIRECTORY_SEPARATOR.'cms'.DIRECTORY_SEPARATOR.$this->getModulesPath().DIRECTORY_SEPARATOR.$this->getCurrentTheme())
            ->setClass('Test')
            ->setModule('dummy')
            ->MakeController()
            ->create();
    }

}
