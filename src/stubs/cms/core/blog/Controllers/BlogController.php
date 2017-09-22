<?php

namespace cms\core\blog\Controllers;

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
use cms\core\blog\Models\BlogModel;
use cms\core\blog\Models\BlogCategoryModel;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            CGate::resouce('blog');
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
       return view('blog::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = BlogCategoryModel::select("name","id",'parent')->get()->toArray();
        $category = $this->buildTree($cat);

        return view('blog::admin.edit',['layout'=>'create','category'=>$category]);
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
            'title' => 'required|unique:'.(new BlogModel)->getTable().',title|max:191',
            'category' => 'required|exists:'.(new BlogCategoryModel)->getTable().',id',
            'image' => 'required',
            'content' => 'required',
            'status' => 'required'
        ]);


        $data = new BlogModel;
        $data->title = mb_convert_case($request->title, MB_CASE_TITLE, "UTF-8");
        $data->category_id  = $request->category;
        $data->content = $request->contents;
        $data->image = $request->image;
        $data->status = $request->status;
        $data->created_by = User::getUser()->id;

        if($data->save()){
            $msg = "Blog Save Success";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect(route('blog.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo "hai";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = BlogCategoryModel::select("name","id",'parent')->get()->toArray();
        $category = $this->buildTree($cat);
        $data = BlogModel::with('category')->find($id);

        return view('blog::admin.edit',['layout'=>'edit','category'=>$category,'data'=>$data]);
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
            'title' => 'required|unique:'.(new BlogModel)->getTable().',title,'.$id.'|max:191',
            'category' => 'required|exists:'.(new BlogCategoryModel)->getTable().',id',
            'image' => 'required',
            'contents' => 'required',
            'status' => 'required'
        ]);


        $data = BlogModel::find($id);
        $data->title = mb_convert_case($request->title, MB_CASE_TITLE, "UTF-8");
        $data->category_id  = $request->category;
        $data->content = $request->contents;
        $data->image = $request->image;
        $data->status = $request->status;

        if($data->save()){
            $msg = "Blog Save Success";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect(route('blog.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        foreach ($request->selected_blogs as $category)
        {
            BlogModel::find($category)->delete();
        }
        Session::flash('success', 'Blog Deleted Successfully');
        return redirect(route('blog.index'));
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


        $data = BlogModel::with('category')->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'),'blog.*',"id","title",DB::raw('(CASE WHEN '.DB::getTablePrefix().'blog.status = "0" THEN "Disabled" ELSE "Enabled" END) AS status'))
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
                return '<a class="editbutton btn btn-default" data-toggle="modal" data="'.$data->id.'" href="'.route("blog.edit",$data->id).'" ><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit</a>';
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
        CGate::authorize('edit-blog');

        if(!empty($request->selected_blogs))
        {
            $obj = new BlogModel;
            foreach ($request->selected_blogs as $k => $v) {

                //echo $v;
                if($item = $obj->find($v))
                {
                    $item->status = $request->action;
                    $item->save();

                }

            }

        }

        Session::flash("success","User Status changed Successfully!!");
        return redirect()->back();
    }
    /*
     * build blog category tree
     */
    private function buildTree(array $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['child'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

}
