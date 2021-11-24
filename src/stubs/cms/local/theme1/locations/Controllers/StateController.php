<?php

namespace cms\locations\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

use cms\locations\Models\StatesModel;
use cms\locations\Models\CountriesModel;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use cms\core\gate\helpers\CGate;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            CGate::resouce('locations');
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
        $countries = CountriesModel::orderBy('name')->pluck('name', 'id');
        return view('locations::admin.state.index')->with('countries', $countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = CountriesModel::orderBy('name')->pluck('name', 'id');
        return view('locations::admin.state.edit', ['layout' => 'create', 'countries' => $countries]);
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
            'name' => 'required|unique:' . DB::getTablePrefix() . (new StatesModel)->getTable() . ',name|max:191',
            'country_id' => 'required|exists:' . DB::getTablePrefix() . (new CountriesModel())->getTable() . ',id',
            'status' => 'required'
        ]);

        $obj = new StatesModel;
        $obj->name = $request->name;
        $obj->country_id = $request->country_id;
        $obj->status = $request->status;
        $obj->save();

        Session::flash("success", "state save successfully");
        return redirect()->route('state.index');
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
        $obj = StatesModel::findOrFail($id);
        $countries = CountriesModel::orderBy('name')->pluck('name', 'id');
        return view('locations::admin.state.edit', ['layout' => 'edit', 'data' => $obj, 'countries' => $countries]);
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
            'name' => 'required|max:191|unique:' . DB::getTablePrefix() . (new StatesModel)->getTable() . ',name,' . $id,
            'status' => 'required',
            'country_id' => 'required|exists:' . DB::getTablePrefix() . (new CountriesModel())->getTable() . ',id',

        ]);

        $obj = StatesModel::find($id);
        $obj->name = $request->name;
        $obj->country_id = $request->country_id;
        $obj->status = $request->status;
        $obj->save();

        Session::flash("success", "state save successfully");
        return redirect()->route('state.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (!empty($request->selected_state)) {
            $delObj = new StatesModel;
            foreach ($request->selected_state as $k => $v) {

                //echo $v;
                if ($delItem = $delObj->find($v)) {
                    $delItem->delete();
                }
            }
        }

        Session::flash("success", "State Deleted Successfully!!");
        return redirect()->route("state.index");
    }
    /*
     * import data from csv
     */
    public function import(Request $request)
    {
        return view('locations::admin.state.import');
    }
    /*
     * do import
     */
    public function doImport(Request $request)
    {
        $path = $request->file('csv_file')->getRealPath();

        $data = array_map('str_getcsv', file($path));
        if (isset($request->header)) {
            unset($data[0]);
        }

        foreach ($data as $state) {
            $obj = new StatesModel;
            $obj->name = $state[0];
            $obj->country_id = $state[1] ?? '';
            $obj->status = $state[2] ?? 1;
            $obj->save();
        }

        Session::flash("success", "updated");
        return redirect()->route('state.index');
    }

    public function getData(Request $request)
    {
        CGate::authorize('view-locations');
        $limit = ctype_digit($request->get('length')) ? $request->get('length') : 50;
        $sTart = ctype_digit($request->get('start')) ? $request->get('start') : 0;
        //$sTart = 0;

        DB::statement(DB::raw('set @rownum=' . (int) $sTart));


        $data = StatesModel::select(
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            "states.id as id",
            "states.name as name",
            "countries.name as country_name",
            DB::raw('(CASE WHEN ' . DB::getTablePrefix() . (new StatesModel)->getTable() . '.status = "0" THEN "Disabled" 
            WHEN ' . DB::getTablePrefix() . (new StatesModel)->getTable() . '.status = "-1" THEN "Trashed"
            ELSE "Enabled" END) AS status')
        )
            ->join('countries', 'countries.id', '=', 'states.country_id');


        $datatables = Datatables::of($data)
            //->addColumn('check', '{!! Form::checkbox(\'selected_users[]\', $id, false, array(\'id\'=> $rownum, \'class\' => \'catclass\')); !!}{!! Html::decode(Form::label($rownum,\'<span></span>\')) !!}')
            ->addColumn('check', function ($data) {
                if ($data->id != '1')
                    return $data->rownum;
                else
                    return '';
            })
            ->addColumn('actdeact', function ($data) {
                if ($data->id != '1') {
                    $statusbtnvalue = $data->status == "Enabled" ? "<i class='glyphicon glyphicon-remove'></i>&nbsp;&nbsp;Disable" : "<i class='glyphicon glyphicon-ok'></i>&nbsp;&nbsp;Enable";
                    return '<a class="statusbutton btn btn-default" data-toggle="modal" data="' . $data->id . '" href="">' . $statusbtnvalue . '</a>';
                } else
                    return '';
            })
            ->addColumn('action', function ($data) {
                return '<a class="editbutton btn btn-default" data-toggle="modal" data="' . $data->id . '" href="' . route("state.edit", $data->id) . '" ><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit</a>';
                //return $data->id;
            });



        // return $data;
        if (count((array) $data) == 0)
            return [];

        return $datatables->make(true);
    }

    /*
     * country bulk action
     * eg : trash,enabled,disabled
     * delete is destroy function
     */
    function statusChange(Request $request)
    {
        CGate::authorize('edit-locations');

        if (!empty($request->selected_state)) {
            $obj = new StatesModel();
            foreach ($request->selected_state as $k => $v) {

                //echo $v;
                if ($item = $obj->find($v)) {
                    $item->status = $request->action;
                    $item->save();
                }
            }
        }

        Session::flash("success", "State Status changed Successfully!!");
        return redirect()->back();
    }
    /*
     * get states based on country
     */
    function getStates($country_id, array $where = [['id', '!=', 0]])
    {
        $obj =  StatesModel::where('country_id', $country_id)
            ->where($where)
            ->pluck('name', 'id');

        return $obj;
    }
}
