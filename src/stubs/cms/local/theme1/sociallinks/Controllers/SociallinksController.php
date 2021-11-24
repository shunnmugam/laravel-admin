<?php

namespace cms\sociallinks\Controllers;

use cms\sociallinks\Models\SocialLinksModel;

use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SociallinksController extends Controller
{
	public function index()
	{
		$data = SocialLinksModel::pluck('link', 'name')->toArray();
		return view('sociallinks::admin.index', ['data' => $data]);
	}
	/*
    *store function
    */
	public function store(Request $request)
	{
		$this->validate($request, [
			'social' => 'array'
		]);
		$sel_array = array('');
		foreach ($request->social as $key => $value) {
			$count = SocialLinksModel::where('name', '=', $key)->count();
			if ($count != 0 && $value != '') {
				$obj = SocialLinksModel::where('name', '=', $key)->first();
				$obj->name = $key;
				$obj->link = $value;
				$obj->save();
				$sel_array[] = $key;
			}

			if ($value != '' && $count == 0) {
				$obj = new SocialLinksModel;
				$obj->name = $key;
				$obj->link = $value;
				$obj->save();
				$sel_array[] = $key;
			}
		}

		SocialLinksModel::whereNotIn('name', $sel_array)->delete();


		Session::flash('success', 'save success');
		return redirect()->back();
	}
	public function Plugindisplay()
	{
		return SocialLinksModel::pluck('link', 'name')->toArray();
	}
}
