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
    /*
     * current theme
     */
    public $currentTheme;
    /*
     * skin path
     */
    public $skinPath;
    /*
     * skin base path
     */
    public $skinBasePath;
    /*
     * fall back theme
     */
    public $fallBackTheme;

    public function __construct()
    {
        $this->currentTheme = $this->getCurrentTheme();
        $this->skinPath = $this->getSkinPath();
        $this->skinBasePath = $this->getConfig()['skin']['path'];
        $this->fallBackTheme = $this->getFallBackTheme();

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
        return $this->getConfig()['module']['local_path'].DIRECTORY_SEPARATOR.$this->currentTheme;
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

        foreach($modules as $key => $module)
        {
            $path_arry = explode(DIRECTORY_SEPARATOR,$module);
            $current_module = $path_arry[count((array) $path_arry)-1];
            $json_file = json_decode(file_get_contents($module.DIRECTORY_SEPARATOR.$this->getModulesConfigurationName()), true);
           // $path =array("path"=>$this->getPath().DIRECTORY_SEPARATOR.$this->getModulesCorePath().DIRECTORY_SEPARATOR.$module);
            $path = array("path"=>$module);
           // print_r($json_file);exit;

            if($json_file['type']=='core')
                $name_space = 'cms'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.$json_file['name'];
            else
                $name_space = 'cms'.DIRECTORY_SEPARATOR.$json_file['name'];

            $json_file['namespace'] = $name_space;

            foreach ($json_file['providers'] as $key => $provider)
            {
                if($json_file['type'] == 'core') {
                    $module_path = $this->getModulesCorePath();
                    $json_file['providers'][$key] = $this->getPath() . '\\' . $module_path . '\\' . $current_module . '\\' . $provider;
                }else {
                    $module_path = 'local';//$this->getModulesLocalPath();
                $json_file['providers'][$key] = $this->getPath().'\\'.$current_module.'\\'.$provider;
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

        if (class_exists(\Configurations::class)) {
           return \Configurations::getCurrentTheme();

        }
        elseif(\Illuminate\Support\Facades\Schema::hasTable('configurations')) {
            $data = \DB::table('configurations')->where('name','=','site')->first();

            if(count((array) $data)>0 && isset($data->parm)) {
                $data =  json_decode($data->parm);

                if(isset($data->active_theme))
                    return $data->active_theme;
            }

        }
        return $this->getThemeConfig()['active'];
    }

    /*
     * skin path
     */
    protected function getSkinPath()
    {
        $skin = 'skin'.'/'.$this->currentTheme;


        //if(!File::exists(asset('/'.'skin'.'/'.$this->currentTheme))) {
            //$skin =  'skin'.'/theme1';
       // }


        return $skin;
    }
    /*
     * get fall back theme
     */
    public function getFallBackTheme()
    {
        return $this->getThemeConfig()['fall_back'];
    }


    /**
     * return html script.
     *
     */
    public function script($url, $attributes = [], $secure = null)
    {
        if (file_exists($this->skinBasePath.'/'.$this->currentTheme.'/'.$url))
            return Html::script($this->skinPath.'/'.$url,$attributes,$secure);
        else
            return Html::script('skin'.'/'.$this->fallBackTheme.'/'.$url,$attributes,$secure);
    }

    /**
     * return html style
     */
    public function style($url, $attributes = [], $secure = null)
    {
        if (file_exists($this->skinBasePath.'/'.$this->currentTheme.'/'.$url))
            return Html::style($this->skinPath.'/'.$url,$attributes,$secure);
        else
            return Html::style('skin'.'/'.$this->fallBackTheme.'/'.$url,$attributes,$secure);

        //return Html::style($this->skinPath.'/'.$url,$attributes,$secure);
    }
    /**
     * return html style
     */
    public function img($url,$alt='image not found',$attributes = [])
    {

        //$src = url('').$url;



       // if (file_exists($src)) {
           // echo public_path();
        //}
        //else
           // echo 'fd';


       // exit;
        return Html::image($url,$alt,$attributes);
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
            ->setPath(base_path().DIRECTORY_SEPARATOR.'cms'.DIRECTORY_SEPARATOR.$this->getModulesPath().DIRECTORY_SEPARATOR.$this->currentTheme)
            ->setClass('Test')
            ->setModule('dummy')
            ->MakeController()
            ->create();
    }

}
