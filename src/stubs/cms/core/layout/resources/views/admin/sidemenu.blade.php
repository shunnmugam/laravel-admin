<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        @foreach(Menu::getAdminMenu() as $menu)
            <div class="menu_section">
                <h3>{{$menu['name']}}</h3>
                <ul class="nav side-menu">
                    @if(count($menu)>0)
                        @php
                            if(isset($menu['group']))
                                printMenuGroup($menu['group'])
                        @endphp
                        <?php
                        if(isset($menu['menu'])){
                        foreach($menu['menu'] as $menus){
                        if($menus['is_url']==0){?>
                        <li><a href="{{route($menus['url'])}}"><i class="{{($menus['icon']) ? $menus['icon'] : ''}}"></i>{{$menus['name']}}</a></li>
                        <?php }
                        else{
                        ?>
                        <li><a href="{{url($menus['url'])}}"><i class="{{($menus['icon']) ? $menus['icon'] : ''}}"></i>{{$menus['name']}}</a></li>
                        <?php
                        }
                        }
                        }
                        ?>
                    @endif
                </ul>
            </div>
        @endforeach

        <?php
        function printMenuGroup($groups,$is_submenu=false)
        {
        foreach($groups as $group) {
        ?>
        <li class="{{($is_submenu) ? 'sub_menu' : ''}}"><a><i class="{{($group['icon']) ? $group['icon'] : ''}}"></i> {{$group['name']}} <span class="fa fa-chevron-down"></span></a>
            @if(isset($group['menu']) && count($group['menu'])>0)
                <ul class="nav child_menu">
                    <?php
                    foreach($group['menu'] as $menus){
                    if($menus['is_url']==0){
                    ?>
                    <li><a href="{{route($menus['url'])}}">{{$menus['name']}}</a></li>
                    <?php
                    }
                    else{
                    ?>
                    <li><a href="{{url($menus['url'])}}">{{$menus['name']}}</a></li>
                    <?php
                    }
                    }
                    if(isset($group['group'])){
                        printMenuGroup($group['group'],true);
                    }
                    ?>
                </ul>
            @endif
        </li>
        <?php

        }
        }
        ?>
    </div>

</div>