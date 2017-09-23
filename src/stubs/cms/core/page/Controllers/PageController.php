<?php

namespace cms\core\page\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

use Yajra\Datatables\Facades\Datatables;

//helpers
use DB;
use User;
use Session;
use CGate;
//models
use cms\core\page\Models\PageModel;
use cms\core\usergroup\Models\UserGroupModel;


class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            CGate::resouce('page',['show']);
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
        return view('page::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $group = UserGroupModel::where('status',1)->orderBy('group','Asc')->pluck("group","id");
        return view('page::admin.edit',['layout'=>'create','group'=>$group]);
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
            'url' => 'required|unique:'.(new PageModel)->getTable().',url|max:15',
            'title' => 'required',
            'page_content' => 'required',
            'can' => 'sometimes',
            'status' => 'required'
        ]);


        $data = new PageModel;
        $data->title = mb_convert_case($request->title, MB_CASE_TITLE, "UTF-8");
        $data->url  = $request->url;
        $data->page_content = $request->page_content;
        $data->status = $request->status;
        $data->can = $request->can;


        if($data->save()){

            $msg = "Users save successfully";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect(route('page.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {

        $data = PageModel::where('url','=',$name)->first();
        $can = $data->can;
        if($can===NULL)
            return view('page::site.page',['data'=>$data]);
        else
        {
            $allow = 0;
            foreach (explode(',',$can) as $group) {
                if(in_array($group,(User::getUserGroup()) ? User::getUserGroup() : array(0) ))
                    $allow =1;
            }
            if($allow==1)
                return view('page::site.page',['data'=>$data]);
            else
                echo "Access Denied";exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PageModel::find($id);
        //print_r($data->group[0]->group);exit;
        $group = UserGroupModel::where('status',1)->orderBy('group','Asc')->pluck("group","id");
        return view('page::admin.edit',['layout'=>'edit','group'=>$group,'data'=>$data]);
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
            'url' => 'required|max:15|unique:'.(new PageModel)->getTable().',url,'.$id,
            'title' => 'required',
            'page_content' => 'required',
            'can' => 'sometimes',
            'status' => 'required'
        ]);


        $data = PageModel::find($id);
        $data->title = mb_convert_case($request->title, MB_CASE_TITLE, "UTF-8");
        $data->url  = $request->url;
        $data->page_content = $request->page_content;
        $data->status = $request->status;
        $data->can = ($request->can) ? implode(',',$request->can) : NULL;

        if($data->save()){

            $msg = "Users save successfully";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect(route('page.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {

        foreach ($request->selected_pages as $page)
        {
            PageModel::find($page)->delete();
        }
        Session::flash('success', 'Page Deleted Successfully');
        return redirect(route('page.index'));
    }

    /*
     * *********************additional methods*************************
     */

    /*
     * get user data
     */
    public function getData(Request $request)
    {
        $sTart = ctype_digit($request->get('start')) ? $request->get('start') : 0 ;
        //$sTart = 0;
        DB::statement(DB::raw('set @rownum='.$sTart));


        $data = PageModel::select(DB::raw('@rownum  := @rownum  + 1 AS rownum'),"id","title","url",DB::raw('(CASE WHEN '.DB::getTablePrefix().(new PageModel)->getTable().'.status = "0" THEN "Disabled" ELSE "Enabled" END) AS status'))

            ->get();

        $datatables = Datatables::of($data)
            ->addColumn('check', function($data) {
                    return $data->rownum;
            })
            ->addColumn('actdeact', function($data) {
                if($data->id != '1'){
                    $statusbtnvalue=$data->status=="Enabled" ? "<i class='glyphicon glyphicon-remove'></i>&nbsp;&nbsp;Disable" : "<i class='glyphicon glyphicon-ok'></i>&nbsp;&nbsp;Enable";
                    return '<a class="statusbutton btn btn-default" data-toggle="modal" data="'.$data->id.'" href="">'.$statusbtnvalue.'</a>';
                }
                else
                    return '';
            })
            ->addColumn('action',function($data){
                return '<a class="editbutton btn btn-default" data-toggle="modal" data="'.$data->id.'" href="'.route("page.edit",$data->id).'" ><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit</a>';
                //return $data->id;
            });



        // return $data;
        if(count($data)==0)
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

        if(!empty($request->selected_pages))
        {
            $obj = new PageModel ;
            foreach ($request->selected_pages as $k => $v) {

                //echo $v;
                if($item = $obj->find($v))
                {
                    $item->status = $request->action;
                    $item->save();

                }

            }

        }

        Session::flash("success","Page Status changed Successfully!!");
        return redirect()->back();
    }
}
