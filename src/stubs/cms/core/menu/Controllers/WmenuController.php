<?php
namespace cms\core\menu\Controllers;
use cms\core\menu\Models\MenuItem;
use cms\core\menu\Models\Menu;
use Illuminate\Http\Request;
use View;
use CGate;

//models
use cms\core\page\Models\PageModel;

class WmenuController extends BaseController {

    public function wmenuindex(Request $request) {
        CGate::authorize('view-menu');

        $menuitems = new MenuItem();
        $menulist = Menu::pluck("name", "id");
        $menulist[0] = "Select menu";

        $app = app();
        $routes = $app->routes->getRoutes();

        //print_r($routes[0]->middleware());exit;

        $pages = PageModel::where('status','=',1)->select('url','title','id')->get();
        if ($request->has("action")) {

            return View::make('wmenu::admin.menu') -> with("menulist", $menulist)->with('pages',$pages)->with('routes',$routes);

        } else {

            $menu = Menu::find($request->input("menu"));
            $menus = $menuitems -> getall($request->input("menu"));
            return View::make('wmenu::admin.menu') -> with("menus", $menus) -> with("indmenu", $menu) -> with("menulist", $menulist)->with('pages',$pages)->with('routes',$routes);

        }
    }
    public function createnewmenu(Request $request) {
        CGate::authorize('create-menu');

        $menu = new Menu();
        $menu -> name = $request->input("menuname");
        $menu -> save();
        return json_encode(array("resp" => $menu -> id));

    }
    public function deleteitemmenu(Request $request) {
        CGate::authorize('delete-menu');

        $menuitem = MenuItem::find($request->input("id"));
        $menuitem -> delete();
    }
    public function deletemenug(Request $request) {
        CGate::authorize('delete-menu');
        $menus = new MenuItem();
        $getall = $menus -> getall($request->input("id"));
        if (count((array) $getall) == 0) {
            $menudelete = Menu::find($request->input("id"));
            $menudelete -> delete();
            return json_encode(array("resp" => "you delete this item"));
        } else {
            return json_encode(array("resp" => "You have to delete all items first", "error" => 1));
        }
    }
    public function updateitem(Request $request) {
        CGate::authorize('edit-menu');
        $menuitem = MenuItem::find($request->input("id"));
        $menuitem -> label = $request->input("label");
        $menuitem -> link = $request->input("url");
        $menuitem ->class = $request->input("clases");
		$menuitem -> save();
	}
    public function addcustommenu(Request $request) {
        CGate::authorize('create-menu');
        $menuitem = new MenuItem();
        $menuitem -> label = $request->input("labelmenu");
        $menuitem -> link = $request->input("linkmenu");
        $menuitem -> menu = $request->input("idmenu");
        $menuitem -> save();
    }
    public function addcustompagemenu() {

        CGate::authorize('create-menu');

        $obj = $request->input("obj");

        foreach ($obj as $ob) {
            $menuitem = new MenuItem();
            $menuitem->label = $ob['title'];
            $menuitem->link = url('/').'/'.$ob['url'];
            $menuitem->menu = $request->input("idmenu");
            $menuitem->save();
        }
    }
    public function generatemenucontrol() {

        CGate::authorize('create-menu');

        if($request->input("idmenu")) {
            $menu = Menu::find($request->input("idmenu"));
        }
        else
            $menu = new Menu;
        $menu -> name = $request->input("menuname");
        $menu -> save();
        foreach ($request->input("arraydata") as $value) {
            $menuitem = MenuItem::find($value["id"]);
            $menuitem -> parent = $value["parent"];
            $menuitem -> sort = $value["sort"];
            $menuitem -> depth = $value["depth"];
            $menuitem -> save();
        }
        echo json_encode(array("resp" => 1));
    }
}