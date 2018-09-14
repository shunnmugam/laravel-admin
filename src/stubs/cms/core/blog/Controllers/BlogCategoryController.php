<?php

namespace cms\core\blog\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//helpers
use DB;
use Session;
use User;
use CGate;
//models
use cms\core\blog\Models\BlogCategoryModel;
use Yajra\DataTables\Facades\DataTables;
class BlogCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            CGate::resouce('blog-category');
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
        return view('blog::admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = BlogCategoryModel::pluck('name','id')->toArray();
        $category = ['0'=>'None']+$category;
        return view('blog::admin.category.edit',['layout'=>'create','category'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:3|unique:'.(new BlogCategoryModel)->getTable(),
            'order' => 'required|int',
            'status' => 'required'
        ]);

        $obj = new BlogCategoryModel;
        $obj->name = $request->name;
        $obj->parent = $request->parent;
        $obj->order = $request->order;
        $obj->image = $request->image;
        $obj->status = $request->status;
        $obj->created_by =User::getUser()->id;
        if($obj->save())
        {
            $msg = "Blog Category save successfully";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect(route('blog-category.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = BlogCategoryModel::where('id','!=',$id)->pluck('name','id')->toArray();
        $category = ['0'=>'None']+$category;
        $data = BlogCategoryModel::findorFail($id);
        return view('blog::admin.category.edit',['layout'=>'edit','category'=>$category,'data'=>$data]);
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
        $this->validate($request,[
            'name' => 'required|min:3|unique:'.(new BlogCategoryModel)->getTable().',name,'.$id,
            'order' => 'required|int',
            'status' => 'required'
        ]);

        $obj = BlogCategoryModel::find($id);
        $obj->name = $request->name;
        $obj->parent = $request->parent;
        $obj->image = $request->image;
        $obj->order = $request->order;
        $obj->status = $request->status;
        if($obj->save())
        {
            $msg = "Blog Category save successfully";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect(route('blog-category.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        foreach ($request->selected_category as $category)
        {
            BlogCategoryModel::find($category)->delete();
        }
        Session::flash('success', 'Category Deleted Successfully');
        return redirect(route('blog-category.index'));

    }

    /*
     * *********************additional methods*************************
     */

    /*
     * get blog data
     */
    public function getData(Request $request)
    {
        $sTart = ctype_digit($request->get('start')) ? $request->get('start') : 0 ;
        //$sTart = 0;
        DB::statement(DB::raw('set @rownum='.$sTart));


        $data = BlogCategoryModel::select(DB::raw('@rownum  := @rownum  + 1 AS rownum'),"id","name",
            DB::raw('(CASE WHEN '.DB::getTablePrefix().(new BlogCategoryModel)->getTable().'.status = "0" THEN "Disabled" 
            WHEN '.DB::getTablePrefix().(new BlogCategoryModel)->getTable().'.status = "-1" THEN "Trashed"
            ELSE "Enabled" END) AS status'))
            ->get();

        $datatables = Datatables::of($data)
            //->addColumn('check', '{!! Form::checkbox(\'selected_users[]\', $id, false, array(\'id\'=> $rownum, \'class\' => \'catclass\')); !!}{!! Html::decode(Form::label($rownum,\'<span></span>\')) !!}')
            ->addColumn('check', function($data) {
                if($data->id != '1')
                    return $data->rownum;
                else
                    return '';
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
                return '<a class="editbutton btn btn-default" data-toggle="modal" data="'.$data->id.'" href="'.route("blog-category.edit",$data->id).'" ><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit</a>';
                //return $data->id;
            });



        // return $data;
        if(count($data)==0)
            return [];

        return $datatables->make(true);
    }

    /*
     * blog bulk action
     * eg : trash,enabled,disabled
     * delete is destroy function
     */
    function statusChange(Request $request)
    {

        if(!empty($request->selected_category))
        {

            $obj = new BlogCategoryModel;
            foreach ($request->selected_category as $k => $v) {

                //echo $v;
                if($item = $obj->find($v))
                {
                    $item->status = $request->action;
                    $item->save();

                }

            }

        }

        Session::flash("success","Blog Category Status changed Successfully!!");
        return redirect()->back();
    }
}
