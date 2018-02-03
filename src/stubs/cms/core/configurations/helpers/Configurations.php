<?php
namespace cms\core\configurations\helpers;

//helpers
use Auth;
use cms\core\module\Models\ModuleModel;
use Session;
use Cms;
//models
use cms\core\user\Models\UserModel;
use cms\core\configurations\Models\ConfigurationModel;

//others
use Illuminate\Http\Request;
class Configurations
{
    function __construct()
    {

    }
    /*
     * get module configuration parm
     * type=1 is core,type =2 is local
     */
    public static function getParm($module,$type=2)
    {
       $parm =  ModuleModel::select('configuration_parm')
            ->where('name','=',$module)
            ->where('type','=',$type)
            ->first();
       if($parm)
           $parm = json_decode($parm->configuration_parm);

       return $parm;
    }
    public static function getConfig($name)
    {
        $parm = ConfigurationModel::where('name',$name)->select('parm')->first();

        if($parm)
            $parm = json_decode($parm->parm);

        return $parm;
    }

    public static function getAllConfig()
    {
        $parm = ConfigurationModel::pluck('parm','name');

        foreach ($parm as $key => $value)
            $parm[$key] = json_decode($value);

        return $parm;
    }

    public static function getCurrentTheme()
    {
        $data = ConfigurationModel::where('name','=','site')->first();

        if(count($data)>0 && isset($data->parm)) {
            $data =  json_decode($data->parm);

            if(isset($data->active_theme))
                return $data->active_theme;
        }

        return Cms::getThemeConfig()['active'];

    }
}
