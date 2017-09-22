<!DOCTYPE html>
<html>
<head>
    @if(trim($__env->yieldContent('sIte_tItle')))
        <title> Family Tree| @yield('sIte_tItle')</title>
    @else
        <title></title>
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1">
    {!!Html::style('skin/theme1/theme/vendors/bootstrap/dist/css/bootstrap.min.css')!!}
    {!!Html::script('skin/theme1/theme/vendors/jquery/dist/jquery.min.js')!!}
    {!!Html::script('skin/theme1/theme/vendors/bootstrap/dist/js/bootstrap.min.js')!!}

    {!!Html::style('css/animate.min.css')!!}
    {!!Html::script('js/wow.min.js')!!}

    {!!Html::style('css/reset.css')!!}
    {!!Html::style('css/top.css')!!}
    {!!Html::script('js/modernizr.js')!!}


    @yield('addlinks')

    <style type="text/css">
        .familytreehead.container-fluid {
            background-image: url("/images/header_img.jpg");
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }
        .regs {
            background-image: url("/images/regs.jpg");
            background-size: 100% 100%;
            background-repeat: no-repeat;
            margin-top: 34px;

        }
        .site_fm_lg {
            max-width: 83%;
        }

        .login_s {
            float: left;
            background-image: url("/images/log.jpg");
        //background-size: 100% 100%;
            background-repeat: no-repeat;
            padding-left: 62px;
            background-position: 28px -1px;
            margin-top: 8px;
            font-weight: bold;
            color: white;
            padding-bottom: 12px;
        }

        .reg_s {

            background-image: url("/images/re.jpg");
        //background-size: 100% 100%;
            background-repeat: no-repeat;
            padding-left: 37px;
            margin-top: 7px;
            background-position: 0px -1px;
            font-weight: bold;
            color: white;
        }
        .ser {
            background-image: url("/images/search.png");
            background-repeat: no-repeat;
            width: 75%;
            height: 37px;
            border-radius: 19px;
            background-size: 12% 104%;
            background-position: 272px;
            padding-left: 21px;
            padding-top: 3px;
        }
        .ser::placeholder {
        //color: red;
            margin-left: 18px !important;
            font-size: 15px;
            font-family: Myriad Pro;
        }
        .search_bx {
            margin-top: 31px;
            margin-left: 29px;
        }
        .menu_b {
            background-image: url("/images/menuback.jpg");
            background-repeat: no-repeat;
            background-size: 100% 89%;
            float: left;
            width: 159px;
            text-align: center;
            padding-bottom: 48px;
            margin-right: -1px;
            padding-top: 18px;
        }
        .menu_b:hover {
            background-image: url("/images/menuback_hover.jpg");
            background-repeat: no-repeat;
        }.menu_b.active{
             background-image: url("/images/menuback_hover.jpg") !important;
             background-repeat: no-repeat;
         }
        .family_menu.container-fluid {
            background-color: rgb(249,249,249);
        }
        .menu_b a {
            color: rgb(113,59,23);
            font-family: Segoe Print;
            font-weight: bold;
            font-size: 12px;
        }
        .menusfamil {
            margin: 0 auto;
            width: 86%;
        }
        .footer_c {
            background-color: rgb(94,4,4);
        }
        .copytxt {
            margin-top: 20px;
            margin-bottom: 20px;
            color: white;
            font-family: initial;
            font-size: 12px;
        }
        .desgn {
            margin-top: 20px;
            margin-bottom: 20px;
            color: white;
            text-align: center;
            font-family: initial;
            font-size: 12px;
        }

    </style>
</head>
<body>
@include('layout::site.notifications')
<div class="familytreehead container-fluid">
    <div class="container head_fm">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 site_logo wow bounceIn" data-wow-duration="150ms">
            <img class="site_fm_lg" src="/images/logo.jpg">
        </div>

        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 site_search wow bounceIn" data-wow-duration="150ms">
            <div class="search_bx" >
                <input class="ser" type="text" name="search" placeholder="Search...">
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 site_login">
            <div class="row regs main-nav">
                @includeIf(Plugins::get('LRpopup')[0],['data'=>Plugins::get('LRpopup')[1]])
            </div>

        </div>
    </div>
</div>



<div class="family_menu container-fluid">
    <div class="family_menu2 container">
        <div class="menusfamil wow bounceIn" data-wow-duration="150ms">
            <p class="menu_b"> <a class="menufam" href="{{route('home')}}">HOME</a></p>
            <p class="menu_b active"><a class="menufam" href="{{route('ourstory')}}">OUR STORY</a></p>
            <p class="menu_b"><a class="menufam" href="{{route('tree')}}">TREE</a></p>
            <p class="menu_b"><a class="menufam" href="{{route('gallery')}}">GALLERY</a></p>
            <p class="menu_b"><a class="menufam" href="{{route('events')}}">EVENTS</a></p>
            <p class="menu_b"><a class="menufam" href="{{route('kids')}}">KIDS CORNER</a></p>

        </div>
    </div>
</div>
<div id="feedback"></div>
@yield('body')
<div class="familytreefoot container-fluid">
    <div class="container foot_m">
        <div class="foot_menu">

        </div>
        <div class="foot_menu newsleetter">

        </div>
    </div>
</div>

<div class="container-fluid footer_c">
    <div class="container copy2">
        <p class="col-lg-6 copytxt">CopyRight 2017 Family Tree.All Right Reserved</p>
        <p class="col-lg-6 desgn">Designed by Kamjen Group Of India</p>
    </div>
</div>


@includeIf(Plugins::get('Feedback')[0],['data'=>Plugins::get('Feedback')[1]])



</body>
</html>