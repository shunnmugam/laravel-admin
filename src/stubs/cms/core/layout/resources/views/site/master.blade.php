<!DOCTYPE html>
<html>
<head>
    @if(trim($__env->yieldContent('sIte_tItle')))
        <title>  @yield('sIte_tItle')</title>
    @else
        <title></title>
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1">
   {!!Cms::style('theme/vendors/bootstrap/dist/css/bootstrap.min.css')!!}
    {!!Cms::style('css/extra-bootstrap.css')!!}
	{!!Cms::style('css/animate.min.css')!!}
	{!!Cms::style('css/reset.css')!!}
    {!!Cms::style('css/top.css')!!}

    {!!Cms::script('theme/vendors/jquery/dist/jquery.min.js')!!}
    {!!Cms::script('theme/vendors/bootstrap/dist/js/bootstrap.min.js')!!}
    {!!Cms::script('js/wow.min.js')!!}
    {!!Cms::script('js/modernizr.js')!!}


    @yield('addlinks')

    <style type="text/css">
        .familytreehead.container-fluid {
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }
        .regs {
            background-size: 100% 100%;
            background-repeat: no-repeat;
            margin-top: 34px;

        }
        .site_fm_lg {
            max-width: 83%;
        }

        .login_s {
            float: left;

        //background-size: 100% 100%;
            background-repeat: no-repeat;
            padding-left: 62px;
            background-position: 28px -1px;
            margin-top: 8px;
            font-weight: bold;
            color: white;
            padding-bottom: 12px;
        }
        a.cd-signin , a.cd-signup {
            color: red;
        }
        .reg_s {

        //background-size: 100% 100%;
            background-repeat: no-repeat;
            padding-left: 37px;
            margin-top: 7px;
            background-position: 0px -1px;
            font-weight: bold;
            color: white;
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
            <a href="{{url('/')}}"><img class="site_fm_lg" src="/skin/logo.png"></a>
        </div>

        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 site_search wow bounceIn" data-wow-duration="150ms">
		   <div class="search_bx" >
                {{ Form::open(array('id' => 'site_search','url'=>array('search'), 'method' => 'GET')) }}
                <div class="search-div">
                {{ Form::text('search',
                ((Request::url()==url('/search') && app('request')->input('search')!='')
                ? app('request')->input('search') : ''),
                ['class'=>"ser",'placeholder'=>"Search..."]) }}
                    <button type="submit">
                    <img class="img img-responsive" src="{{skin('/images/search.png')}}">
                    </button>
                </div>
                {{ Form::close() }}
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 site_login">
            <div class="row regs main-nav">
                @includeIf(Plugins::get('LRpopup')[0],['data'=>Plugins::get('LRpopup')[1]])
            </div>

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
        <p class="col-lg-6 copytxt">CopyRight 2017 .All Right Reserved</p>
        <p class="col-lg-6 desgn">Designed by </p>
    </div>
</div>


@includeIf(Plugins::get('Feedback')[0],['data'=>Plugins::get('Feedback')[1]])

@section('script')

@endsection
</body>
</html>
