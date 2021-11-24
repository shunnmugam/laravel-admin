<?php

namespace cms\locations\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

use cms\locations\Models\CountriesModel;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use cms\core\gate\helpers\CGate;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            CGate::resouce('country');
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
        return view('locations::admin.country.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('locations::admin.country.edit', ['layout' => 'create']);
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
            'name' => 'required|unique:' . DB::getTablePrefix() . (new CountriesModel)->getTable() . ',name|max:191',
            'short_name' => 'required|max:7',
            'status' => 'required'
        ]);

        $obj = new CountriesModel;
        $obj->name = $request->name;
        $obj->short_name = $request->short_name;
        $obj->status = $request->status;
        $obj->save();

        Session::flash("success", "country save successfully");
        return redirect()->route('country.index');
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
        $obj = CountriesModel::findOrFail($id);
        return view('locations::admin.country.edit', ['layout' => 'edit', 'data' => $obj]);
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
            'name' => 'required|max:191|unique:' . DB::getTablePrefix() . (new CountriesModel)->getTable() . ',name,' . $id,
            'status' => 'required',
            'short_name' => 'required|max:7'

        ]);

        $obj = CountriesModel::find($id);
        $obj->name = $request->name;
        $obj->short_name = $request->short_name;
        $obj->status = $request->status;
        $obj->save();

        Session::flash("success", "country save successfully");
        return redirect()->route('country.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (!empty($request->selected_country)) {
            $delObj = new CountriesModel;
            foreach ($request->selected_country as $k => $v) {

                //echo $v;
                if ($delItem = $delObj->find($v)) {
                    $delItem->delete();
                }
            }
        }

        Session::flash("success", "Country Deleted Successfully!!");
        return redirect()->route("country.index");
    }
    /*
     * import data from csv
     */
    public function import(Request $request)
    {
        return view('locations::admin.country.country_import');
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

        foreach ($data as $country) {
            $obj = new CountriesModel;
            $obj->name = $country[0];
            $obj->short_name = $country[1] ?? '';
            $obj->country_code = $country[2] ?? '';
            $obj->status = $country[3] ?? 1;
            $obj->save();
        }

        Session::flash("success", "updated");
        return redirect()->route('country.index');
    }

    public function getData(Request $request)
    {
        CGate::authorize('view-country');

        $sTart = ctype_digit($request->get('start')) ? $request->get('start') : 0;
        //$sTart = 0;
        DB::statement(DB::raw('set @rownum=' . $sTart));


        $data = CountriesModel::select(
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            "id",
            "name",
            "short_name",
            DB::raw('(CASE WHEN ' . DB::getTablePrefix() . (new CountriesModel)->getTable() . '.status = "0" THEN "Disabled" 
            WHEN ' . DB::getTablePrefix() . (new CountriesModel)->getTable() . '.status = "-1" THEN "Trashed"
            ELSE "Enabled" END) AS status')
        )
            ->get();

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
                return '<a class="editbutton btn btn-default" data-toggle="modal" data="' . $data->id . '" href="' . route("country.edit", $data->id) . '" ><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit</a>';
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
        CGate::authorize('edit-country');

        if (!empty($request->selected_country)) {
            $obj = new CountriesModel();
            foreach ($request->selected_country as $k => $v) {

                //echo $v;
                if ($item = $obj->find($v)) {
                    $item->status = $request->action;
                    $item->save();
                }
            }
        }

        Session::flash("success", "Country Status changed Successfully!!");
        return redirect()->back();
    }
}
