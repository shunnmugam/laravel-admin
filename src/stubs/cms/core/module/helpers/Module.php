<?php
namespace cms\core\module\helpers;

//helpers
use Cms;

//models
use cms\core\module\Models\ModuleModel;
Class Module
{
    public static function registerModule()
    {
        $modules = Cms::allModules();

        //print_r($modules);exit;
        foreach ($modules as $module)
        {
            $type = (($module['type']=='core') ? 1 : 2);
            $old = ModuleModel::select('version','id')
                ->where('name','=',$module['name'])
                ->where('type','=',$type)->first();
            //already available
            if(count($old)>0)
            {
                //check version is same
                if($old->version != $module['version'])
                {
                    $obj = ModuleModel::find($old->id);
                    $obj->version = $module['version'];
                    if(isset($module['configuration']))
                        $obj->configuration_view = $module['configuration'];
                    if(isset($module['configuration_data']))
                        $obj->configuration_data = $module['configuration_data'];
                    $obj->save();
                }
            }
            else
            {
                $obj = new ModuleModel;
                $obj->name = $module['name'];
                $obj->type = $type;
                $obj->version = $module['version'];
                if(isset($module['configuration']))
                    $obj->configuration_view = $module['configuration'];
                if(isset($module['configuration_data']))
                    $obj->configuration_data = $module['configuration_data'];
                $obj->status = 1;
                $obj->save();

            }

        }
    }

    public static function getId($module_name,$type=2)
    {
         $data =  ModuleModel::where('name','=',$module_name)
                        ->where('type',$type)
                        ->select('id')
                        ->first();
         if(count($data))
             return $data->id;
         else
             return 0;
    }
}