<?php

namespace cms\core\feedback\Controllers;

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
use cms\core\feedback\Models\FeedBackModel;


class FeedBackController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            CGate::resouce('feedback');
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
        return view('feedback::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feedback::admin.edit',['layout'=>'create']);
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
            'username' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);

        $obj = new FeedBackModel;
        $obj->username = $request->username;
        $obj->message = $request->message;
        $obj->email = $request->email;
        $obj->status = $request->status;

        if($obj->save()){
            $msg = "Feedback save successfully";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect()->route('feedback.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = FeedBackModel::findorFail($id);
        return view('feedback::admin.edit',['data'=>$data,'layout'=>'edit']);
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
        'username' => 'required',
        'email' => 'required',
        'message' => 'required'
    ]);

        $obj = FeedBackModel::find($id);
        $obj->username = $request->username;
        $obj->message = $request->message;
        $obj->email = $request->email;
        $obj->status = $request->status;

        if($obj->save()){
            $msg = "Feedback save successfully";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect()->route('feedback.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        foreach($request->selected_feedbacks as $feedback)
        {
            $obj = FeedBackModel::find($feedback)->delete();
        }
        Session::flash('success', 'Feedback deleted success');
        return redirect()->route('feedback.index');
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


        $data = FeedBackModel::select(DB::raw('@rownum  := @rownum  + 1 AS rownum'),"id","username","email","message")
            ->get();

        $datatables = Datatables::of($data)
            //->addColumn('check', '{!! Form::checkbox(\'selected_users[]\', $id, false, array(\'id\'=> $rownum, \'class\' => \'catclass\')); !!}{!! Html::decode(Form::label($rownum,\'<span></span>\')) !!}')
            ->addColumn('check', function($data) {
                if($data->id != '1')
                    return $data->rownum;
                else
                    return '';
            })
            ->addColumn('action',function($data){
                return '<a class="editbutton btn btn-default" data-toggle="modal" data="'.$data->id.'" href="'.route("feedback.edit",$data->id).'" >Edit</a>';
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

        if(!empty($request->selected_feedbacks))
        {
            $obj = new FeedBackModel;
            foreach ($request->selected_feedbacks as $k => $v) {

                //echo $v;
                if($item = $obj->find($v))
                {
                    $item->status = $request->action;
                    $item->save();

                }

            }

        }

        Session::flash("success","Feedback Status changed Successfully!!");
        return redirect()->back();
    }
    /*
     * do feedback from frond end
     */
    public function dofeedback(Request $request)
    {
        $obj = new FeedBackModel;
        $obj->username = $request->username;
        $obj->message = $request->message;
        $obj->email = $request->email;
        if($request->image) {
            $usr_obj = new \User;

            $obj->image = $usr_obj->imageCreate($request->image,'feedback/user/');
        }
        $obj->save();

        return 1;

    }
}
