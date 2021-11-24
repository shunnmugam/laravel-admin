<?php

namespace cms\core\search\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use Cms;

class SearchController extends Controller
{
    function index(Request $request)
    {
        if ($request->search != '') {
            $all_module = Cms::allModules();

            $search_array = array();
            foreach ($all_module as $module) {
                if (isset($module['search'])) {
                    foreach ($module['search'] as $name => $search) {
                        $search_array[$name] = $module['namespace'] . '\\' . $search;
                    }
                }
            }

            $data = array();
            $allItems = new \Illuminate\Database\Eloquent\Collection;
            foreach ($search_array as $key => $search) {
                $obj = new $search;

                $temp = $obj->data->toArray();

                foreach ($temp as $t_key => $res) {
                    $temp[$t_key]['view'] = $obj->view;
                    $temp[$t_key]['name'] = $key;

                    $data[] = $temp[$t_key];
                }
            }
        } else
            $data = array();


        $currentPage = LengthAwarePaginator::resolveCurrentPage() - 1;

        //Create a new Laravel collection from the array data
        $collection = new Collection($data);


        //Define how many items we want to be visible in each page
        $perPage = 10;

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice($currentPage * $perPage, $perPage)->all();

        //Create our paginator and pass it to the view
        $result = new LengthAwarePaginator($currentPageSearchResults, count((array) $collection), $perPage);

        //print_r($paginatedSearchResults);exit;

        $result->setPath('/search');

        return view('search::site.result', compact('result'));
    }
}
