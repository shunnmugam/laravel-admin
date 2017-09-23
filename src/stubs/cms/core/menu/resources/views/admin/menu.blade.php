@php
use Illuminate\Support\Facades\Input;
@endphp

@extends('layout::admin.master')

@section('title','user')
@section('style')
{!!Cms::style('theme/vendors/menu/style.css')!!}
<script type="text/javascript">
    var menus = {
        "oneThemeLocationNoMenus" : "",
        "moveUp" : "Move up",
        "moveDown" : "Mover down",
        "moveToTop" : "Move top",
        "moveUnder" : "Move under of %s",
        "moveOutFrom" : "Out from under  %s",
        "under" : "Under %s",
        "outFrom" : "Out from %s",
        "menuFocus" : "%1$s. Element menu %2$d of %3$d.",
        "subMenuFocus" : "%1$s. Menu of subelement %2$d of %3$s."
    };
</script>
@endsection
@section('body')
<div class="wp-admin wp-core-ui js menu-max-depth-0 nav-menus-php auto-fold admin-bar sticky-menu">
<div id="wpwrap">
    <div id="wpcontent">
        <div id="wpbody">
            <div id="wpbody-content">

                <div class="wrap">
                    <h2 class="nav-tab-wrapper"><a href="{{route('wmenuindex')}}" class="nav-tab nav-tab-active">Edit Menu</a><!---<a href="{{route('wmenuindex')}}?action=locations" class="nav-tab">Gestionar lugares</a>--></h2>
                    <div class="manage-menus">
                        <form method="get" action="{{route('wmenuindex')}}">
                            <label for="menu" class="selected-menu">Select the menu you want to edit:</label>

                            {{ Form::select('menu', $menulist,0) }}

                            <span class="submit-btn">
										<input type="submit" class="button-secondary" value="Choose">
									</span>
                            <span class="add-new-menu-action"> or <a href="{{route('wmenuindex')}}?action=edit&menu=0">Create new menu</a>. </span>
                        </form>
                    </div>
                    <div id="nav-menus-frame">

                        @if(Input::has('menu'))
                        <div id="menu-settings-column" class="metabox-holder">

                            <div class="clear"></div>

                            <form id="nav-menu-meta" action="" class="nav-menu-meta" method="post" enctype="multipart/form-data">
                                <div id="side-sortables" class="accordion-container">
                                    <ul class="outer-border">
                                        <li class="control-section accordion-section  open add-page" id="add-page">
                                            <h3 class="accordion-section-title hndle" tabindex="0"> Custom Link <span class="screen-reader-text">Press return or enter to expand</span></h3>
                                            <div class="accordion-section-content ">
                                                <div class="inside">
                                                    <div class="customlinkdiv" id="customlinkdiv">
                                                        <p id="menu-item-url-wrap">
                                                            <label class="howto" for="custom-menu-item-url"> <span>URL</span>
                                                                <input id="custom-menu-item-url" name="url" type="text" class="code menu-item-textbox" value="http://">
                                                            </label>
                                                        </p>

                                                        <p id="menu-item-name-wrap">
                                                            <label class="howto" for="custom-menu-item-name"> <span>Label</span>
                                                                <input id="custom-menu-item-name" name="label" type="text" class="regular-text menu-item-textbox input-with-default-title" title="Label menu">
                                                            </label>
                                                        </p>

                                                        <p class="button-controls">

                                                            <a  href="#" onclick="addcustommenu()"  class="button-secondary submit-add-to-menu right"  >Add menu item</a>
                                                            <span class="spinner" id="spincustomu"></span>
                                                        </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="control-section accordion-section  open add-page" id="add-page">
                                            <h3 class="accordion-section-title hndle" tabindex="1"> Page Link <span class="screen-reader-text">Press return or enter to expand</span></h3>
                                            <div class="accordion-section-content ">
                                                <div class="inside">
                                                    <div class="customlinkdiv">
                                                        @foreach($pages as $page)
                                                            <input id="page-{{$page->id}}" name="page" type="checkbox" data-title="{{$page->url}}" data-url="{{$page->url}}">
                                                            <label for="page-{{$page->id}}">{{$page->title}}</label>
                                                        @endforeach

                                                        <p class="button-controls">

                                                            <a  href="#" onclick="addcustompagemenu()"  class="button-secondary submit-add-to-menu right"  >Add menu item</a>
                                                            <span class="spinner" id="spincustomu"></span>
                                                        </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="control-section accordion-section  open add-page" id="add-page">
                                            <h3 class="accordion-section-title hndle" tabindex="1">Routes <span class="screen-reader-text">Press return or enter to expand</span></h3>
                                            <div class="accordion-section-content ">
                                                <div class="inside">
                                                    <div class="customlinkdiv">

                                                        @foreach ($routes as $key => $route )
                                                            @if($route->methods()[0]=="GET" && !in_array('Admin',$route->middleware()))
                                                                <div class="xs-12">
                                                                <input id="route-{{$key}}" name="route" type="checkbox" data-title="{{$route->uri}}" data-url="{{$route->uri}}">
                                                                <label for="route-{{$key}}">{{$route->uri}}</label>
                                                                </div>
                                                            @endif
                                                        @endforeach

                                                        <p class="button-controls">

                                                            <a  href="#" onclick="addcustompagemenu(1)"  class="button-secondary submit-add-to-menu right"  >Add menu item</a>
                                                            <span class="spinner" id="spincustomu"></span>
                                                        </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </form>

                        </div>
                        @endif
                        <div id="menu-management-liquid">
                            <div id="menu-management">
                                <form id="update-nav-menu" action="" method="post" enctype="multipart/form-data">
                                    <div class="menu-edit ">
                                        <div id="nav-menu-header">
                                            <div class="major-publishing-actions">
                                                <label class="menu-name-label howto open-label" for="menu-name"> <span>Name</span>
                                                    <input name="menu-name" id="menu-name" type="text" class="menu-name regular-text menu-item-textbox" title="Enter menu name" value="@if(isset($indmenu)){{$indmenu->name}}@endif">
                                                    <input type="hidden" id="idmenu" value="@if(isset($indmenu)){{$indmenu->id}}@endif" />
                                                </label>

                                                @if(Input::has('action'))
                                                <div class="publishing-action">
                                                    <a onclick="createnewmenu()" name="save_menu" id="save_menu_header" class="button button-primary menu-save">Create menu</a>
                                                </div>
                                                @elseif(Input::has("menu"))
                                                <div class="publishing-action">
                                                    <a onclick="getmenus()" name="save_menu" id="save_menu_header" class="button button-primary menu-save">Save menu</a>
                                                </div>

                                                @else
                                                <div class="publishing-action">
                                                    <a onclick="createnewmenu()" name="save_menu" id="save_menu_header" class="button button-primary menu-save">Create menu</a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div id="post-body">
                                            <div id="post-body-content">

                                                @if(Input::has("menu"))
                                                <h3>Menu Structure</h3>
                                                <div class="drag-instructions post-body-plain" style="">
                                                    <p>
                                                        Place each item in the order you prefer. Click on the arrow to the right of the item to display more configuration options.
                                                    </p>
                                                </div>

                                                @else
                                                <h3>Menu Creation</h3>
                                                <div class="drag-instructions post-body-plain" style="">
                                                    <p>
                                                        Please enter the name and select "Create menu" button
                                                    </p>
                                                </div>
                                                @endif

                                                <ul class="menu ui-sortable" id="menu-to-edit">
                                                    @if(isset($menus))
                                                    @foreach($menus as $m)
                                                    <li id="menu-item-{{$m->id}}" class="menu-item menu-item-depth-{{$m->depth}} menu-item-page menu-item-edit-inactive pending" style="display: list-item;">
                                                        <dl class="menu-item-bar">
                                                            <dt class="menu-item-handle">
                                                                <span class="item-title"> <span class="menu-item-title"> <span id="menutitletemp_{{$m->id}}">{{$m->label}}</span> <span style="color: transparent;">|{{$m->id}}|</span> </span> <span class="is-submenu" style="@if($m->depth==0)display: none;@endif">Subelement</span> </span>
                                                                <span class="item-controls"> <span class="item-type">Link</span> <span class="item-order hide-if-js"> <a href="{{route('wmenuindex')}}?action=move-up-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44" class="item-move-up"><abbr title="Move Up">↑</abbr></a> | <a href="{{route('wmenuindex')}}?action=move-down-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44" class="item-move-down"><abbr title="Move Down">↓</abbr></a> </span> <a class="item-edit" id="edit-{{$m->id}}" title=" " href="{{route('wmenuindex')}}?edit-menu-item={{$m->id}}#menu-item-settings-{{$m->id}}"> </a> </span>
                                                            </dt>
                                                        </dl>

                                                        <div class="menu-item-settings" id="menu-item-settings-{{$m->id}}">
                                                            <p class="description description-thin">
                                                                <label for="edit-menu-item-title-{{$m->id}}"> Label
                                                                    <br>
                                                                    <input type="text" id="idlabelmenu_{{$m->id}}" class="widefat edit-menu-item-title" name="idlabelmenu_{{$m->id}}" value="{{$m->label}}">
                                                                </label>
                                                            </p>

                                                            <p class="field-css-classes description description-thin">
                                                                <label for="edit-menu-item-classes-{{$m->id}}"> Class CSS (optional)
                                                                    <br>
                                                                    <input type="text" id="clases_menu_{{$m->id}}" class="widefat code edit-menu-item-classes" name="clases_menu_{{$m->id}}" value="{{$m->class}}">
                                                                </label>
                                                            </p>

                                                            <p class="field-css-classes description description-wide">
                                                                <label for="edit-menu-item-classes-{{$m->id}}"> Url
                                                                    <br>
                                                                    <input type="text" id="url_menu_{{$m->id}}" class="widefat code edit-menu-item-classes" id="url_menu_{{$m->id}}" value="{{$m->link}}">
                                                                </label>
                                                            </p>

                                                            <p class="field-move hide-if-no-js description description-wide">
                                                                <label> <span>Move</span> <a href="{{route('wmenuindex')}}?action=edit&menu=26#" class="menus-move-up" style="display: none;">Move up</a> <a href="{{route('wmenuindex')}}?action=edit&menu=26#" class="menus-move-down" title="Mover uno abajo" style="display: inline;">Move Down</a> <a href="{{route('wmenuindex')}}?action=edit&menu=26#" class="menus-move-left" style="display: none;"></a> <a href="{{route('wmenuindex')}}?action=edit&menu=26#" class="menus-move-right" style="display: none;"></a> <a href="{{route('wmenuindex')}}?action=edit&menu=26#" class="menus-move-top" style="display: none;">Top</a> </label>
                                                            </p>

                                                            <div class="menu-item-actions description-wide submitbox">

                                                                <a class="item-delete submitdelete deletion" id="delete-{{$m->id}}" href="{{route('wmenuindex')}}?action=delete-menu-item&menu-item={{$m->id}}&_wpnonce=2844002501">Delete</a>
                                                                <span class="meta-sep hide-if-no-js"> | </span>
                                                                <a class="item-cancel submitcancel hide-if-no-js button-secondary" id="cancel-{{$m->id}}" href="{{route('wmenuindex')}}?edit-menu-item={{$m->id}}&cancel=1424297719#menu-item-settings-{{$m->id}}">Cancel</a>
                                                                <span class="meta-sep hide-if-no-js"> | </span>
                                                                <a onclick="updateitem({{$m->id}})" class="button button-primary updatemenu" id="update-{{$m->id}}" href="javascript:void(0)">Update item</a>

                                                            </div>

                                                        </div>
                                                        <ul class="menu-item-transport"></ul>
                                                    </li>
                                                    @endforeach
                                                    @endif
                                                </ul>
                                                <div class="menu-settings">

                                                </div>
                                            </div>
                                        </div>
                                        <div id="nav-menu-footer">
                                            <div class="major-publishing-actions">

                                                @if(Input::has('action'))
                                                <div class="publishing-action">
                                                    <a onclick="createnewmenu()" name="save_menu" id="save_menu_header" class="button button-primary menu-save">Create menu</a>
                                                </div>
                                                @elseif(Input::has("menu"))
                                                <span class="delete-action"> <a class="submitdelete deletion menu-delete" onclick="deletemenu()" href="javascript:void(9)">Delete menu</a> </span>
                                                <div class="publishing-action">
                                                    <a onclick="getmenus()" name="save_menu" id="save_menu_header" class="button button-primary menu-save">Save menu</a>
                                                </div>

                                                @else
                                                <div class="publishing-action">
                                                    <a onclick="createnewmenu()" name="save_menu" id="save_menu_header" class="button button-primary menu-save">Create menu</a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
    @endsection
    @section('script')

    {!! Cms::script("theme/vendors/menu/scripts.js") !!}
    {!! Cms::script("theme/vendors/menu/scripts2.js") !!}
    {!! Cms::script("theme/vendors/menu/menu.js") !!}


    <script>
        var arraydata = [];
        var csrf = "{{csrf_token()}}";

        var addcustommenur= "{{route('addcustommenu')}}";
        var addcustompagemenur= "{{route('addcustompagemenu')}}";
        var updateitemr= "{{route('updateitem')}}";
        var generatemenucontrolr="{{route('generatemenucontrol')}}";
        var deleteitemmenur="{{route('deleteitemmenu')}}";
        var deletemenugr="{{route('deletemenug')}}";
        var createnewmenur="{{route('createnewmenu')}}";
        var menuwr="{{route('wmenuindex')}}";
    </script>
    <div class="clear"></div>
</div>

@endsection