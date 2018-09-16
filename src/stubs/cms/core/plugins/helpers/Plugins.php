<?php
/**
 * Created by PhpStorm.
 * User: Ramesh
 * Date: 9/9/2017
 * Time: 5:05 PM
 */
namespace cms\core\plugins\helpers;
//helpers
use Cms;
use User;
//models
use cms\core\plugins\Models\PluginsModel;

class Plugins
{
    /*
     * protected plugin
     */
    protected $plugin;

    public static function registerPlugins()
    {
        $ids = array();
        foreach(Cms::getPlugins() as $module => $plugin)
        {
            //$role_value['module'] = $module;
            //$role_value['id'] = $role['id'];
            //$role_value['type'] = $role['type'];
            $plugin_value['plugins'] =  include($plugin['plugins']);

            foreach ( $plugin_value['plugins'] as $plugin_name => $plugin_valu) {
                $row = PluginsModel::select('id')
                    ->where('name', '=', $plugin_name)
                    ->first();
                if(count((array) $row))
                {
                    $row = PluginsModel::find($row->id);
                    $row->name = $plugin_name;
                    $row->version  = $plugin_valu['version'];
                    $row->action  = $plugin_valu['action'];
                    $row->view  = $plugin_valu['view'];
                    $row->adminview  = $plugin_valu['adminview'];
                    $row->save();

                    $ids[] = $row->id;
                }
                else
                {
                    $row = new PluginsModel;
                    $row->name = $plugin_name;
                    $row->version  = $plugin_valu['version'];
                    $row->action  = $plugin_valu['action'];
                    $row->view  = $plugin_valu['view'];
                    $row->adminview  = $plugin_valu['adminview'];
                    $row->status = 0;

                    $row->save();

                    $ids[] = $row->id;
                }
            }
        }
        //delete not avalable plugins
        PluginsModel::whereNotIn('id',$ids)->delete();
    }
    /*
     * get name
     */
    public static function getName($plugin_id)
    {
        return count((array) $data = self::getOptions($plugin_id))>0 ? $data->name : '';
    }
    /*
     * get plugins
     */
    public static function getParm($plugin_id)
    {
        $parm = PluginsModel::select('parms')
            ->where('id','=',$plugin_id)
            ->where('status',1)
            ->first();
        return (count((array) $parm)>0) ? $parm->parm : array();
    }
    /*
     * get options
     */
    public static function getOptions($plugin_id)
    {
        $parm = PluginsModel::select('*')
            ->where('id','=',$plugin_id)
            ->where('status',1)
            ->first();
        return (count((array) $parm)>0) ? $parm : array();
    }

    public static function get($name)
    {
        $plugin = PluginsModel::where('name','=',$name)
                    ->where('status',1)
                    ->first();

        if(count((array) $plugin)==0)
            return ['',''];

        $action = explode('@',$plugin->action);

        $class= $action[0];
        $function= $action[1];
        $obj =  new $class;

        $data = $obj->$function();

        //print_r(json_decode($plugin->parms));exit;

        return [$plugin->view,$data,json_decode($plugin->parms)];


    }


}