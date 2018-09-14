<?php

namespace cms\core\newsletter\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CGate;
use DB;
use User;
use Session;
use Mail;
use CmsMail;
use cms\core\newsletter\Mail\NewsLetterMail;
use cms\core\newsletter\Jobs\SendNewsLetter;

use Yajra\DataTables\Facades\Datatables;

//models
use cms\core\newsletter\Models\NewsLetterModel;
use cms\core\newsletter\Mail\SubscriptionConfirmMail;
use Illuminate\Console\Scheduling\Schedule;

class NewsletterController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            CGate::resouce('newsletter');
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
        return view('newsletter::admin.view_sub');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newsletter::admin.edit',['layout'=>'create']);
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
            'email' => 'required|email|unique:newsletter_subscribers,email',
            'status' => 'required'
        ]);

        $obj = new NewsLetterModel;
        $obj->email = $request->email;
        $obj->status = isset($request->status) ? $request->status : 1;
        if($obj->save())
        {
            $msg = "Subscriber Created successfully";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect()->route('subscriber.index');
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
        $data = NewsLetterModel::findOrFail($id);
        return view('newsletter::admin.edit',['layout'=>'edit','data'=>$data]);

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
            'email' => 'required|email|unique:newsletter_subscribers,email,'.$id,
            'status' => 'required'
        ]);

        $obj =  NewsLetterModel::findOrFail($id);
        $obj->email = $request->email;
        $obj->status = $request->status;
        if($obj->save())
        {
            $msg = "Subscriber Updated successfully";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect()->route('subscriber.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        if(!empty($request->selected_users))
        {

            $delObj = new NewsLetterModel();
            foreach ($request->selected_users as $k => $v) {

                //echo $v;
                if($delItem = $delObj->find($v))
                {
                    $delItem->delete();

                }

            }

        }

        Session::flash("success","Subscriber Deleted Successfully!!");
        return redirect()->route("subscriber.index");
    }



    /*
     * *********************additional methods*************************
     */

    /*
     * get blog data
     */
    public function getData(Request $request)
    {
        CGate::authorize('view-newsletter');

        $sTart = ctype_digit($request->get('start')) ? $request->get('start') : 0 ;
        //$sTart = 0;
        DB::statement(DB::raw('set @rownum='.$sTart));


        $data = NewsLetterModel::select('*',DB::raw('@rownum  := @rownum  + 1 AS rownum'),DB::raw('(CASE WHEN status = "0" THEN "Disabled" ELSE "Enabled" END) AS status'))
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
                return '<a class="editbutton btn btn-default" data-toggle="modal" data="'.$data->id.'" href="'.route("subscriber.edit",$data->id).'" ><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit</a>';
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
        CGate::authorize('edit-newsletter');

        if(!empty($request->selected_users))
        {
            $obj = new NewsLetterModel();
            foreach ($request->selected_users as $k => $v) {

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
     * create email
     */
    public function createMail(Request $request)
    {
        return view('newsletter::admin.create');
    }
    /*
     * send email to all
     */
    public function sendMail(Request $request,Schedule $schedule)
    {


        $to = NewsLetterModel::where('status','=',1)->pluck('email');

        \CmsMail::setMailConfig();
        if(count($to)!=0) {
            $to = $to->toArray();


            //$schedule->command('queue:listen --once')->withoutOverlapping();

            $when = \Carbon\Carbon::now()->addMinutes(1);
            //dispatch(new SendNewsLetter($to,$request->contents));
            foreach ($to as $to_mail)
                Mail::to($to_mail)->later($when,new NewsLetterMail($request->contents));
        }

        Session::flash("success","Mail Send Successfully!!");
        return redirect()->back();

    }

    function storeFromSite(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|unique:newsletter_subscribers,email',
            'status' => 'sometimes'
        ]);

        $obj = new NewsLetterModel;
        $obj->email = $request->email;
        $obj->status = isset($request->status) ? $request->status : 1;
        if($obj->save())
        {
            Mail::to($request->email)->queue(new SubscriptionConfirmMail());

            $msg = "Join successfully";
            $class_name = "success";
        }
        else{
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect()->back();
    }

    function removeFromSite(Request $request)
    {
        NewsLetterModel::where(DB::raw('md5(email)') , $request->address)->delete();

        Session::flash('success', 'un subscribe successfully');
        return redirect()->route('home');
    }

    //plugin
    function Plugindisplay()
    {

    }
}
