<!--This is admin master page -->
<!-- author: Ramesh -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : '' }}| Administrator</title>


    <!-- Bootstrap -->
    {!!Cms::style('theme/vendors/bootstrap/dist/css/bootstrap.min.css')!!}
    <!-- Font Awesome -->
    {!!Cms::style('theme/vendors/font-awesome/css/font-awesome.min.css')!!}
    <!-- NProgress -->
    {!!Cms::style('theme/vendors/nprogress/nprogress.css')!!}
    <!-- iCheck -->
    {!!Cms::style('theme/vendors/iCheck/skins/flat/green.css')!!}


    <!-- bootstrap-progressbar -->
    {!!Cms::style('theme/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')!!}
    <!-- bootstrap-daterangepicker -->
    {!!Cms::style('theme/vendors/bootstrap-daterangepicker/daterangepicker.css')!!}

    <!-- PNotify -->
    {!!Cms::style('theme/vendors/pnotify/dist/pnotify.css')!!}
    {!!Cms::style('theme/vendors/pnotify/dist/pnotify.buttons.css')!!}


    @yield('style')

    <!-- Custom Theme Style -->
    {!!Cms::style('theme/build/css/custom.min.css')!!}
</head>
<body class="nav-md">
<div class="container body">
    <div class="main_container">


        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{route('backenddashboard')}}" class="site_title"><i class="fa fa-paw"></i>
                        <span>{{isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : 'Laravel Cms'}}</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="{{((User::getUser()->images!='') ? User::getUser()->images : '/images/no-image.png' )}}" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>{{session('ACTIVE_USERNAME')}}</h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br />

                <!-- sidebar menu -->
                    @include('layout::admin.sidemenu')
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{route('log_out_from_admin')}}">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>
        <!--top nav -->
            @include('layout::admin.top_nav')
        <!--- top nav end -->
        <!-- page content -->
        <div class="right_col" role="main">

            @yield('body')

        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>


    <!-------------------------------------SCRIPT--------------------------------------------------->
    <!-- jQuery -->
    {!! Cms::script('theme/vendors/jquery/dist/jquery.min.js') !!}
    <!-- Bootstrap -->
    {!! Cms::script('theme/vendors/bootstrap/dist/js/bootstrap.min.js') !!}
    <!-- NProgress -->
    {!! Cms::script('theme/vendors/nprogress/nprogress.js') !!}
    <!-- bootstrap-daterangepicker -->
    {!! Cms::script('theme/vendors/moment/min/moment.min.js') !!}
    {!! Cms::script('theme/vendors/bootstrap-daterangepicker/daterangepicker.js') !!}

    <!-- bootstrap-progressbar -->
    {!! Cms::script('theme/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') !!}
    <!-- iCheck -->
    {!! Cms::script('theme/vendors/iCheck/icheck.min.js') !!}
    <!-- PNotify -->
    {!! Cms::script('theme/vendors/pnotify/dist/pnotify.js') !!}
    {!! Cms::script('theme/vendors/pnotify/dist/pnotify.buttons.js') !!}

    <!-- Custom Theme Scripts -->
    {!! Cms::script('theme/build/js/custom.min.js') !!}

<!---------------widgets--------------------->
<!---------NOTIFICATIONS--------->
<script>
    $('document').ready(function() {
        function notify(title,text,type,hide) {
            new PNotify({
                title: title,
                text: text,
                type: type,
                hide: hide,
                styling: 'bootstrap3'
            })
        }
        @if(Session::has("success"))
            notify('Success','{{Session::get("success")}}','success',true);
        @endif
        @if(Session::has("error"))
            notify('Error','{{Session::get("error")}}','error',true);
        @endif
        @if(Session::has("info"))
            notify('Info','{{Session::get("info")}}','info',true);
        @endif

        @if(count($errors) > 0)
        @foreach ($errors->all() as $error)
            notify('Error','{{$error}}','error',true);
        @endforeach
        @endif

    });
</script>
@yield('script_link')
@yield('script')

</body>
</html>