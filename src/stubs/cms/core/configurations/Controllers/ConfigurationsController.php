<?php
namespace cms\core\configurations\Controllers;

use App\Http\Controllers\Controller;
use cms\core\module\Models\ModuleModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Session;
use DB;
use Configurations;
use Cms;
use File;

//models
use cms\core\configurations\Models\ConfigurationModel;



class ConfigurationsController extends Controller
{
    /********************************Module Configurations *******************************/
    /*
     * redirect module configuration view
     */
    public function module($module_id)
    {
        $config_data = ModuleModel::findorFail($module_id);
        $datas = '';
        if($config_data->configuration_data)
        {
            $action = explode('@',$config_data->configuration_data);

            $class= $action[0];
            $function= $action[1];
            $obj =  new $class;

            $datas = $obj->$function();
        }

        if($config_data->configuration_parm)
        {
            $config_data->configuration_parm = json_decode($config_data->configuration_parm);
        }
        return view('configurations::admin.module',['data'=>$config_data,'datas'=>$datas]);
    }
    /*
     * save module configuration
     */
    public function moduleSave(Request $request)
    {
        $form_data = $request->all();
        $module_id = $form_data['module_id'];
        unset($form_data['_token']);
        unset($form_data['module_id']);
        unset($form_data['submit']);

        $obj = ModuleModel::findorFail($module_id);
        $obj->configuration_parm = json_encode($form_data);
        $obj->save();



        Session::flash('success', 'Success');
        return redirect()->back();
    }
    /*
     * module configuration view share module lists
     */
    public function getModuleList(View $view)
    {
        $module_list = ModuleModel::select('name','id')
            ->where('type','=',DB::raw('(SELECT COUNT(*) FROM '.DB::getTablePrefix().(new ModuleModel)->getTable().' as b WHERE '.DB::getTablePrefix().(new ModuleModel)->getTable().'.name=b.name)'))
            ->where('status',1)
            ->get();

        $view->with('module_list',$module_list);
    }
    /********************************** site Configurations ************************************/
    /*
     * redirect to view
     */
    public function site()
    {

       // echo Cms::getCurrentTheme();exit;
        $list = File::directories(base_path() . DIRECTORY_SEPARATOR . 'cms' . DIRECTORY_SEPARATOR . Cms::getModulesPath());
        $themes = array();
        foreach ($list as $theme) {
            $ee = explode("\\", $theme);
            if(count($ee)==1)
                $ee = explode("/", $theme);
            if(count($ee)==1)
                $ee = explode(DIRECTORY_SEPARATOR, $theme);
            $themes[end($ee)] = end($ee);
        }

        $data = json_decode(@ConfigurationModel::where('name','=','site')->first()->parm);

        //echo $data->site_online;exit;
        return view('configurations::admin.site',['data'=>$data,'themes'=>$themes]);
    }
    /*
     * site configuration save
     */
    public function sitesave(Request $request)
    {
        $obj = ConfigurationModel::where('name','=','site')->first();
        if(count($obj)==0)
            $obj = new ConfigurationModel;

        $form_data = $request->all();
        unset($form_data['_token']);
        unset($form_data['submit_btn']);

        $obj->name = 'site';
        $obj->parm = json_encode($form_data);
        $obj->save();

        Session::flash('success', 'Success');
        return redirect()->back();
    }
    /******************************** Mail Configuration ***************************************/
    /*
     * redirect to view
     */
    function mail()
    {
        $malier = \CmsMail::getMailerList();
        $mailer_names = array();
        foreach($malier as  $name => $value)
        {
            $mailer_names[$name] = $name;
        }
        $data = Configurations::getConfig('mail');
        return view('configurations::admin.mail',['data'=>$data,'mailer'=>$mailer_names]);
    }
    /*
     * mail configuratoin save
     */
    function mailsave(Request $request)
    {
        $obj = ConfigurationModel::where('name','=','mail')->first();
        if(count($obj)==0)
            $obj = new ConfigurationModel;

        $form_data = $request->all();
        unset($form_data['_token']);
        unset($form_data['submit_btn']);
        $form_data['from_mail_password'] = base64_encode($form_data['from_mail_password']);

        $obj->name = 'mail';
        $obj->parm = json_encode($form_data);
        $obj->save();

        Session::flash('success', 'Success');
        return redirect()->back();
    }
}
