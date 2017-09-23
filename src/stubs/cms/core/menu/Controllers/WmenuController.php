<?php
namespace cms\core\menu\Controllers;
use cms\core\menu\Models\MenuItem;
use cms\core\menu\Models\Menu;

use Illuminate\Support\Facades\Input;
use View;

//models
use cms\core\page\Models\PageModel;

class WmenuController extends BaseController {

    public function wmenuindex() {

        $menuitems = new MenuItem();
        $menulist = Menu::pluck("name", "id");
        $menulist[0] = "Select menu";

        $app = app();
        $routes = $app->routes->getRoutes();

        //print_r($routes[0]->middleware());exit;

        $pages = PageModel::where('status','=',1)->select('url','title','id')->get();
        if (Input::has("action")) {

            return View::make('wmenu::admin.menu') -> with("menulist", $menulist)->with('pages',$pages)->with('routes',$routes);

        } else {

            $menu = Menu::find(Input::get("menu"));
            $menus = $menuitems -> getall(Input::get("menu"));
            return View::make('wmenu::admin.menu') -> with("menus", $menus) -> with("indmenu", $menu) -> with("menulist", $menulist)->with('pages',$pages)->with('routes',$routes);

        }
    }
    public function createnewmenu() {

        $menu = new Menu();
        $menu -> name = Input::get("menuname");
        $menu -> save();
        return json_encode(array("resp" => $menu -> id));

    }
    public function deleteitemmenu() {

        $menuitem = MenuItem::find(Input::get("id"));
        $menuitem -> delete();
    }
    public function deletemenug() {

        $menus = new MenuItem();
        $getall = $menus -> getall(Input::get("id"));
        if (count($getall) == 0) {
            $menudelete = Menu::find(Input::get("id"));
            $menudelete -> delete();
            return json_encode(array("resp" => "you delete this item"));
        } else {
            return json_encode(array("resp" => "You have to delete all items first", "error" => 1));
        }
    }
    public function updateitem() {

        $menuitem = MenuItem::find(Input::get("id"));
        $menuitem -> label = Input::get("label");
        $menuitem -> link = Input::get("url");
        $menuitem ->class = Input::get("clases");
		$menuitem -> save();
	}
    public function addcustommenu() {

        $menuitem = new MenuItem();
        $menuitem -> label = Input::get("labelmenu");
        $menuitem -> link = Input::get("linkmenu");
        $menuitem -> menu = Input::get("idmenu");
        $menuitem -> save();
    }
    public function addcustompagemenu() {
        $obj = Input::get("obj");

        foreach ($obj as $ob) {
            $menuitem = new MenuItem();
            $menuitem->label = $ob['title'];
            $menuitem->link = url('/').'/'.$ob['url'];
            $menuitem->menu = Input::get("idmenu");
            $menuitem->save();
        }
    }
    public function generatemenucontrol() {

        if(Input::get("idmenu")) {
            $menu = Menu::find(Input::get("idmenu"));
        }
        else
            $menu = new Menu;
        $menu -> name = Input::get("menuname");
        $menu -> save();
        foreach (Input::get("arraydata") as $value) {
            $menuitem = MenuItem::find($value["id"]);
            $menuitem -> parent = $value["parent"];
            $menuitem -> sort = $value["sort"];
            $menuitem -> depth = $value["depth"];
            $menuitem -> save();
        }
        echo json_encode(array("resp" => 1));
    }
}